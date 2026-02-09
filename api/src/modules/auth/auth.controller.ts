import {
    Controller,
    Post,
    Body,
    HttpCode,
    HttpStatus,
    UnauthorizedException,
} from '@nestjs/common';
import { AuthService } from './auth.service';
import { LoginDto } from './dto/login.dto';
import { LoginResponseDto } from './dto/login-response.dto';

@Controller('auth')
export class AuthController {
    constructor(private authService: AuthService) { }

    @Post('login')
    @HttpCode(HttpStatus.OK)
    async login(@Body() loginDto: LoginDto): Promise<LoginResponseDto> {
        const user = await this.authService.validateUser(
            loginDto.usernameOrEmail,
            loginDto.password,
        );

        if (!user) {
            throw new UnauthorizedException('Invalid credentials');
        }

        return this.authService.login(user as any);
    }
}
