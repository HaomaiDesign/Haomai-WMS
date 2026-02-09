import { TypeOrmModuleOptions } from '@nestjs/typeorm';

export const typeOrmConfig: TypeOrmModuleOptions = {
    type: 'mssql',
    host: process.env.DATABASE_HOST || 'localhost',
    port: parseInt(process.env.DATABASE_PORT || '1433', 10),
    username: process.env.DATABASE_USER || 'sa',
    password: process.env.DATABASE_PASSWORD,
    database: process.env.DATABASE_NAME || 'haomai_wms',
    entities: [__dirname + '/../**/*.entity{.ts,.js}'],
    synchronize: process.env.NODE_ENV === 'development', // Only for development
    logging: process.env.NODE_ENV === 'development',
    options: {
        encrypt: false, // For local development
        trustServerCertificate: true,
    },
};
