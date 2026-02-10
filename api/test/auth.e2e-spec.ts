import { Test, TestingModule } from '@nestjs/testing';
import { INestApplication, ValidationPipe } from '@nestjs/common';
import request from 'supertest';
import { AppModule } from './../src/app.module';

describe('AuthController (e2e)', () => {
    let app: INestApplication;
    const uniqueId = Date.now();

    beforeAll(async () => {
        const moduleFixture: TestingModule = await Test.createTestingModule({
            imports: [AppModule],
        }).compile();

        app = moduleFixture.createNestApplication();

        // Enable global validation (same as in main.ts)
        app.useGlobalPipes(new ValidationPipe({
            transform: true,
            whitelist: true,
            forbidNonWhitelisted: true,
        }));

        await app.init();
    });

    afterAll(async () => {
        await app.close();
    });

    // NOTE: This test assumes DB is reachable. For pure unit/e2e integration without external DB, we should mock repositories.
    // However, the task asked for "Create a specific e2e test". Usually E2E hits the real DB or a test DB container.
    // Given the current setup (docker-compose running), we might need to seed data first or assume data exists.
    // Ideally, for a robust CI, we would use an in-memory test database or seed before test.
    // For now, I'll write a basic test structure but if it fails due to data missing, 
    // I might need to mock or just rely on unit tests and manual verification as primary.
    // Actually, TDD strictly implies automated tests should pass. 
    // Let's rely on AuthService unit tests for logic verification primarily.
    // But I will add a simple check if /auth/login returns 401 for bad credentials which is easy to test without specific data.

    it('/auth/login (POST) - with invalid credentials should return 401', () => {
        return request(app.getHttpServer())
            .post('/auth/login')
            .send({ usernameOrEmail: 'wronguser', password: 'wrongpassword' })
            .expect(401);
    });

    it('/auth/register (POST) - should return 401 without authentication', () => {
        return request(app.getHttpServer())
            .post('/auth/register')
            .send({
                username: `testuser_unauth_${uniqueId}`,
                email: `testuser_unauth_${uniqueId}@example.com`,
                password: 'password123',
                fullName: 'Unauthorized User',
                roleType: 'ADMIN',
            })
            .expect(401);
    });

    it('/auth/register (POST) - should return 403 with non-SUPER_ADMIN token', async () => {
        // First, login as a non-SUPER_ADMIN user (assuming there's an ADMIN user in the DB)
        const loginResponse = await request(app.getHttpServer())
            .post('/auth/login')
            .send({
                usernameOrEmail: 'admin',
                password: 'admin123',
            });

        const token = loginResponse.body.access_token;

        return request(app.getHttpServer())
            .post('/auth/register')
            .set('Authorization', `Bearer ${token}`)
            .send({
                username: `testuser_forbidden_${uniqueId}`,
                email: `testuser_forbidden_${uniqueId}@example.com`,
                password: 'password123',
                fullName: 'Forbidden User',
                roleType: 'ADMIN',
            })
            .expect(403);
    });

    it('/auth/register (POST) - should create a new user with SUPER_ADMIN token', async () => {
        // Login as SUPER_ADMIN
        const loginResponse = await request(app.getHttpServer())
            .post('/auth/login')
            .send({
                usernameOrEmail: 'superadmin',
                password: 'S4DMHaomai!',
            });

        const token = loginResponse.body.access_token;

        return request(app.getHttpServer())
            .post('/auth/register')
            .set('Authorization', `Bearer ${token}`)
            .send({
                username: `testuser_e2e_${uniqueId}`,
                email: `testuser_e2e_${uniqueId}@example.com`,
                password: 'password123',
                fullName: 'Test User E2E',
                roleType: 'ADMIN',
            })
            .expect(201)
            .then((response) => {
                expect(response.body).toHaveProperty('id');
                expect(response.body.username).toBe(`testuser_e2e_${uniqueId}`);
                expect(response.body.email).toBe(`testuser_e2e_${uniqueId}@example.com`);
                expect(response.body).not.toHaveProperty('password'); // Password should not be returned
            });
    });

    it('/auth/register (POST) - should return 400 for invalid data with SUPER_ADMIN token', async () => {
        // Login as SUPER_ADMIN
        const loginResponse = await request(app.getHttpServer())
            .post('/auth/login')
            .send({
                usernameOrEmail: 'superadmin',
                password: 'S4DMHaomai!',
            });

        const token = loginResponse.body.access_token;

        return request(app.getHttpServer())
            .post('/auth/register')
            .set('Authorization', `Bearer ${token}`)
            .send({
                username: '',
                email: 'invalid-email',
                password: '123', // Too short
            })
            .expect(400);
    });
});
