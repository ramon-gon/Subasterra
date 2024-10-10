CREATE DATABASE IF NOT EXISTS subhasta CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE subhasta;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
short_description TEXT,
    long_description TEXT,
    photo VARCHAR(255),
    starting_price DECIMAL(10, 2) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO products (name, short_description, long_description, photo, starting_price) VALUES
('Laptop Acer', 'Portatil lleuger', 'Un portàtil lleuger amb pantalla de 15.6 polzades.', '/../images/images.jpg', 599.99),
('Smartphone Samsung', 'Smartphone amb camera', 'Smartphone amb càmera de 64 MP i bateria de llarga durada.', '/../images/images.jpg', 399.99),
('Auriculars Sony', 'Auriculars sense fil', 'Auriculars sense fil amb cancel·lació de soroll.', '/../images/images.jpg', 199.99),
('Tablet Apple', 'Tablet amb pantalla Retina', 'Tablet amb pantalla Retina de 10.2 polzades i 128 GB de capacitat.', '/../images/images.jpg', 329.99),
('Càmera Canon', 'Camera digital', 'Càmera rèflex digital amb objectiu de 18-55mm.', '/../images/images.jpg', 499.99),
('Laptop Acer2', 'Portatil lleuger', 'Un portàtil lleuger amb pantalla de 15.6 polzades.', '/../images/images.jpg', 599.99),
('Smartphone Samsung2', 'Smartphone amb camera', 'Smartphone amb càmera de 64 MP i bateria de llarga durada.', '/../images/images.jpg', 399.99),
('Auriculars Sony2', 'Auriculars sense fil', 'Auriculars sense fil amb cancel·lació de soroll.', '/../images/images.jpg', 199.99),
('Tablet Apple2', 'Tablet amb pantalla retina', 'Tablet amb pantalla Retina de 10.2 polzades i 128 GB de capacitat.', '/../images/images.jpg', 329.99),
('Càmera Canon2', 'Camera reflex', 'Càmera rèflex digital amb objectiu de 18-55mm.', '/../images/images.jpg', 499.99);
