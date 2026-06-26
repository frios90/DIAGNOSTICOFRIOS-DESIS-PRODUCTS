-- sql/schema.sql
-- All tables and fields in English

DROP TABLE IF EXISTS product_material;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS materials;
DROP TABLE IF EXISTS currencies;
DROP TABLE IF EXISTS branches;
DROP TABLE IF EXISTS warehouses;

-- Warehouse table
CREATE TABLE warehouses (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Branch table
CREATE TABLE branches (
    id SERIAL PRIMARY KEY,
    warehouse_id INTEGER NOT NULL,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id) ON DELETE CASCADE
);

-- Currency table
CREATE TABLE currencies (
    id SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    symbol VARCHAR(5) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Material table
CREATE TABLE materials (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Product table
CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    code VARCHAR(15) UNIQUE NOT NULL,
    name VARCHAR(50) NOT NULL,
    warehouse_id INTEGER NOT NULL,
    branch_id INTEGER NOT NULL,
    currency_id INTEGER NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id),
    FOREIGN KEY (branch_id) REFERENCES branches(id),
    FOREIGN KEY (currency_id) REFERENCES currencies(id)
);

-- Pivot table: Product-Material relationship (many to many)
CREATE TABLE product_material (
    id SERIAL PRIMARY KEY,
    product_id INTEGER NOT NULL,
    material_id INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES materials(id) ON DELETE CASCADE,
    UNIQUE (product_id, material_id)
);