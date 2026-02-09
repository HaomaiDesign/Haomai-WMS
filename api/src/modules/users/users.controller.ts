import { Controller, Get, UseGuards } from '@nestjs/common';
import { JwtAuthGuard } from '../auth/guards/jwt-auth.guard';
import { RolesGuard } from '../auth/guards/roles.guard';
import { Roles } from '../auth/decorators/roles.decorator';
import { CurrentUser } from '../auth/decorators/current-user.decorator';
import { UserRole } from './enums/user-role.enum';

@Controller('users')
export class UsersController {
  @Get('profile')
  @UseGuards(JwtAuthGuard)
  getProfile(@CurrentUser() user: any) {
    return {
      message: 'Your profile',
      user,
    };
  }

  @Get('admin-only')
  @UseGuards(JwtAuthGuard, RolesGuard)
  @Roles(UserRole.ADMIN)
  adminOnly(@CurrentUser() user: any) {
    return {
      message: 'Admin only endpoint',
      user,
    };
  }

  @Get('manager-only')
  @UseGuards(JwtAuthGuard, RolesGuard)
  @Roles(UserRole.MANAGER)
  managerOnly(@CurrentUser() user: any) {
    return {
      message: 'Manager only endpoint',
      user,
    };
  }

  @Get('repositor-only')
  @UseGuards(JwtAuthGuard, RolesGuard)
  @Roles(UserRole.REPOSITOR)
  repositorOnly(@CurrentUser() user: any) {
    return {
      message: 'Repositor only endpoint',
      user,
    };
  }
}
