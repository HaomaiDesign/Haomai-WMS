

import { TypeOrmModuleOptions } from '@nestjs/typeorm';
import { ConfigService } from '@nestjs/config';

export const getTypeOrmConfig = (configService: ConfigService): TypeOrmModuleOptions => ({
    type: 'mssql',
    host: configService.get<string>('DATABASE_HOST', 'localhost'),
    port: parseInt(configService.get<string>('DATABASE_PORT', '1433'), 10),
    username: configService.get<string>('DATABASE_USER', 'sa'),
    password: configService.get<string>('DATABASE_PASSWORD'),
    database: configService.get<string>('DATABASE_NAME', 'haomai_wms'),
    entities: [__dirname + '/../**/*.entity{.ts,.js}'],
    synchronize: false, // Disabled to prevent data loss. Use migrations.
    logging: configService.get<string>('NODE_ENV') === 'development',
    options: {
        encrypt: false, // For local development
        trustServerCertificate: true,
    },
});
