import {
    Entity,
    PrimaryGeneratedColumn,
    Column,
    CreateDateColumn,
    UpdateDateColumn,
} from 'typeorm';
import { UserRole } from '../enums/user-role.enum';

@Entity('users')
export class User {
    @PrimaryGeneratedColumn()
    id: number;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    username: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    email: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true, select: false })
    password: string;

    @Column({ name: 'full_name', type: 'nvarchar', length: 1000, nullable: true })
    fullName: string;

    @Column({
        name: 'personal_id',
        type: 'nvarchar',
        length: 1000,
        nullable: true,
    })
    personalId: string;

    @Column({ name: 'business_id', type: 'int', nullable: true })
    businessId: number;

    @Column({ name: 'role_id', type: 'int', nullable: true })
    roleId: number;

    @Column({
        type: 'nvarchar',
        length: 50,
        nullable: false,
        default: UserRole.REPOSITOR,
    })
    role: UserRole;

    @Column({ name: 'job_title', type: 'nvarchar', length: 1000, nullable: true })
    jobTitle: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    department: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    address: string;

    @Column({
        name: 'postal_code',
        type: 'nvarchar',
        length: 1000,
        nullable: true,
    })
    postalCode: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    location: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    province: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    country: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    phone: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    mobile: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    avatar: string;

    @Column({ name: 'language_id', type: 'int', nullable: true })
    languageId: number;

    @Column({ name: 'registration_date', type: 'date', nullable: true })
    registrationDate: Date;

    @Column({ name: 'last_login', type: 'date', nullable: true })
    lastLogin: Date;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    whatsapp: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    wechat: string;

    @Column({ name: 'tax_id', type: 'nvarchar', length: 1000, nullable: true })
    taxId: string;

    @Column({ type: 'nvarchar', length: 1000, nullable: true })
    description: string;

    @Column({
        name: 'flag_email_checked',
        type: 'bit',
        nullable: true,
        default: false,
    })
    flagEmailChecked: boolean;

    @Column({
        name: 'flag_reset_password',
        type: 'bit',
        nullable: true,
        default: false,
    })
    flagResetPassword: boolean;

    @CreateDateColumn({ name: 'created_at', type: 'datetime2' })
    createdAt: Date;

    @UpdateDateColumn({ name: 'updated_at', type: 'datetime2' })
    updatedAt: Date;
}
