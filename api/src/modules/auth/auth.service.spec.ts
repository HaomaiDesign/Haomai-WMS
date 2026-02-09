import { Test, TestingModule } from '@nestjs/testing';
import { JwtService } from '@nestjs/jwt';
import { AuthService } from './auth.service';
import { UsersService } from '../users/users.service';
import { User } from '../users/entities/user.entity';
import { UserRole } from '../users/enums/user-role.enum';
import * as bcrypt from 'bcrypt';

// Mock bcrypt
jest.mock('bcrypt');

describe('AuthService', () => {
    let service: AuthService;
    let usersService: UsersService;
    let jwtService: JwtService;

    const mockUser: User = {
        id: 1,
        username: 'testuser',
        email: 'test@example.com',
        password: '$2b$10$hashedpassword', // bcrypt hash
        role: UserRole.ADMIN,
        fullName: 'Test User',
        personalId: null,
        businessId: 1,
        roleId: 1,
        jobTitle: null,
        department: null,
        address: null,
        postalCode: null,
        location: null,
        province: null,
        country: null,
        phone: null,
        mobile: null,
        avatar: null,
        languageId: null,
        registrationDate: null,
        lastLogin: null,
        whatsapp: null,
        wechat: null,
        taxId: null,
        description: null,
        flagEmailChecked: false,
        flagResetPassword: false,
        createdAt: new Date(),
        updatedAt: new Date(),
    };

    const mockUsersService = {
        findByUsername: jest.fn(),
        findByEmail: jest.fn(),
    };

    const mockJwtService = {
        sign: jest.fn(),
    };

    beforeEach(async () => {
        const module: TestingModule = await Test.createTestingModule({
            providers: [
                AuthService,
                {
                    provide: UsersService,
                    useValue: mockUsersService,
                },
                {
                    provide: JwtService,
                    useValue: mockJwtService,
                },
            ],
        }).compile();

        service = module.get<AuthService>(AuthService);
        usersService = module.get<UsersService>(UsersService);
        jwtService = module.get<JwtService>(JwtService);
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    describe('validateUser', () => {
        it('should return user without password if credentials are valid (username)', async () => {
            const plainPassword = 'password123';
            mockUsersService.findByUsername.mockResolvedValue(mockUser);
            jest.spyOn(bcrypt, 'compare').mockImplementation(() => Promise.resolve(true));

            const result = await service.validateUser('testuser', plainPassword);

            expect(result).toBeDefined();
            expect(result.id).toBe(mockUser.id);
            expect(result.username).toBe(mockUser.username);
            expect(result.password).toBeUndefined(); // Password should not be included
            expect(mockUsersService.findByUsername).toHaveBeenCalledWith('testuser');
        });

        it('should return user without password if credentials are valid (email)', async () => {
            const plainPassword = 'password123';
            mockUsersService.findByUsername.mockResolvedValue(null);
            mockUsersService.findByEmail.mockResolvedValue(mockUser);
            jest.spyOn(bcrypt, 'compare').mockImplementation(() => Promise.resolve(true));

            const result = await service.validateUser('test@example.com', plainPassword);

            expect(result).toBeDefined();
            expect(result.id).toBe(mockUser.id);
            expect(result.email).toBe(mockUser.email);
            expect(result.password).toBeUndefined();
            expect(mockUsersService.findByEmail).toHaveBeenCalledWith('test@example.com');
        });

        it('should return null if user is not found', async () => {
            mockUsersService.findByUsername.mockResolvedValue(null);
            mockUsersService.findByEmail.mockResolvedValue(null);

            const result = await service.validateUser('nonexistent', 'password123');

            expect(result).toBeNull();
        });

        it('should return null if password is incorrect', async () => {
            mockUsersService.findByUsername.mockResolvedValue(mockUser);
            jest.spyOn(bcrypt, 'compare').mockImplementation(() => Promise.resolve(false));

            const result = await service.validateUser('testuser', 'wrongpassword');

            expect(result).toBeNull();
        });
    });

    describe('login', () => {
        it('should return access token and role', async () => {
            const mockToken = 'mock.jwt.token';
            mockJwtService.sign.mockReturnValue(mockToken);

            const result = await service.login(mockUser);

            expect(result).toEqual({
                access_token: mockToken,
                role: UserRole.ADMIN,
            });
            expect(mockJwtService.sign).toHaveBeenCalledWith({
                sub: mockUser.id,
                username: mockUser.username,
                role: mockUser.role,
            });
        });
    });

    describe('hashPassword', () => {
        it('should hash a password using bcrypt', async () => {
            const plainPassword = 'password123';
            const hashedPassword = '$2b$10$hashedpassword';
            (bcrypt.hash as jest.Mock).mockResolvedValue(hashedPassword);

            const result = await service.hashPassword(plainPassword);

            expect(result).toBeDefined();
            expect(result).toBe(hashedPassword);
            expect(bcrypt.hash).toHaveBeenCalledWith(plainPassword, 10);
        });

        it('should generate different hashes for the same password', async () => {
            const plainPassword = 'password123';
            (bcrypt.hash as jest.Mock)
                .mockResolvedValueOnce('$2b$10$hash1')
                .mockResolvedValueOnce('$2b$10$hash2');

            const hash1 = await service.hashPassword(plainPassword);
            const hash2 = await service.hashPassword(plainPassword);

            expect(hash1).not.toBe(hash2); // Different salts should produce different hashes
        });
    });
});
