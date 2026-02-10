import { Injectable, UnauthorizedException } from '@nestjs/common';
import { JwtService } from '@nestjs/jwt';
import { UsersService } from '../users/users.service';
import { User } from '../users/entities/user.entity';
import { CreateUserDto } from '../users/dto/create-user.dto';
import { LoginResponseDto } from './dto/login-response.dto';
import * as bcrypt from 'bcrypt';

@Injectable()
export class AuthService {
    constructor(
        private usersService: UsersService,
        private jwtService: JwtService,
    ) { }

    async validateUser(
        usernameOrEmail: string,
        password: string,
    ): Promise<Omit<User, 'password'> | null> {
        // Try to find by username first
        let user = await this.usersService.findByUsername(usernameOrEmail);

        // If not found, try by email
        if (!user) {
            user = await this.usersService.findByEmail(usernameOrEmail);
        }

        // If user not found, return null
        if (!user) {
            return null;
        }

        // Validate password
        const isPasswordValid = await bcrypt.compare(password, user.password);

        if (!isPasswordValid) {
            return null;
        }

        // Remove password from user object before returning
        const { password: _, ...result } = user;
        return result;
    }

    async login(user: User): Promise<LoginResponseDto> {
        const payload = {
            sub: user.id,
            username: user.username,
            role: user.roleType,
        };

        const { password, ...userWithoutPassword } = user;

        return {
            access_token: this.jwtService.sign(payload),
            role: user.roleType,
            user: userWithoutPassword,
        };
    }

    async hashPassword(password: string): Promise<string> {
        return bcrypt.hash(password, 10);
    }

    async register(createUserDto: CreateUserDto): Promise<User> {
        // Hash the password
        const hashedPassword = await this.hashPassword(createUserDto.password);

        // Create user with hashed password
        const userToCreate = {
            ...createUserDto,
            password: hashedPassword,
        };

        // Delegate to UsersService
        return this.usersService.create(userToCreate);
    }
}
