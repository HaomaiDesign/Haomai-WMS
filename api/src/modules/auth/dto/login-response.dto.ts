import { UserRole } from '../../users/enums/user-role.enum';

export class LoginResponseDto {
    access_token: string;
    role: UserRole;
}
