-- sql/datos.sql
-- Sample data (values in Spanish for UI display)

-- Insert warehouses
INSERT INTO warehouses (name) VALUES
('Bodega Central'),
('Bodega Norte'),
('Bodega Sur');

-- Insert branches
INSERT INTO branches (warehouse_id, name) VALUES
(1, 'Sucursal Centro'),
(1, 'Sucursal Independencia'),
(2, 'Sucursal La Molina'),
(2, 'Sucursal San Isidro'),
(3, 'Sucursal Miraflores'),
(3, 'Sucursal Barranco');

-- Insert currencies (Latin American currencies)
INSERT INTO currencies (name, symbol) VALUES
('Peso Chileno', 'CLP'),
('Peso Argentino', 'ARS'),
('Sol Peruano', 'PEN'),
('Peso Colombiano', 'COP'),
('Peso Mexicano', 'MXN'),
('Real Brasileño', 'BRL'),
('Boliviano', 'BOB'),
('Dólar Americano', 'USD'),
('Dólar Canadiense', 'CAD'),
('Peso Uruguayo', 'UYU'),
('Guaraní Paraguayo', 'PYG'),
('Bolívar Venezolano', 'VES');

-- Insert materials
INSERT INTO materials (name) VALUES
('Plástico'),
('Metal'),
('Madera'),
('Vidrio'),
('Textil');