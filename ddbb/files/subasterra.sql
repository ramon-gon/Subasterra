DROP DATABASE IF EXISTS subasterra;

CREATE DATABASE IF NOT EXISTS subasterra CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE subasterra;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(20) NOT NULL,
    role ENUM('venedor', 'subhastador') NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO users (username, password, role) VALUES 
('venedor1', 'venedor1', 'venedor'),
('venedor2', 'venedor2', 'venedor'),
('subhastador', 'subhastador', 'subhastador');

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    short_description TEXT,
    long_description TEXT,
    observations TEXT,
    starting_price DECIMAL(10, 2) NOT NULL,
    last_bid DECIMAL(10,2) NOT NULL DEFAULT 0,
    photo VARCHAR(50),
    status ENUM('pendent', 'rebutjat', 'pendent d’assignació a una subhasta', 'assignat a una subhasta', 'pendent_adjudicacio', 'venut', 'retirat') DEFAULT 'pendent',
    auctioneer_message TEXT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS auctions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auction_date TIMESTAMP,
    description TEXT,
    status ENUM('oberta', 'tancada') NOT NULL DEFAULT 'oberta',
    percentage INT NOT NULL DEFAULT 10 CHECK (percentage BETWEEN 0 AND 100)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS auction_products (
    auction_id INT,
    product_id INT,
    PRIMARY KEY (auction_id, product_id),
    FOREIGN KEY (auction_id) REFERENCES auctions(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT,
    is_read BOOLEAN DEFAULT FALSE,
    sender INT,
    receiver INT,
    FOREIGN KEY (sender) REFERENCES users(id),
    FOREIGN KEY (receiver) REFERENCES users(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO products (name, short_description, long_description, observations, photo, starting_price, user_id) VALUES
('Televisor LG', 'Televisor 4K UHD', 'Televisor LG de 55 polzades amb resolució 4K i compatibilitat amb HDR.', 'Pantalla amb alta resolució i colors vius.', '/../images/images.jpg', 699.99, 2),
('Consola PlayStation 5', 'Consola de nova generació', 'Consola de jocs PlayStation 5 amb gràfics de nova generació i SSD ultra ràpid.', 'Inclou un controlador extra i un joc.', '/../images/images.jpg', 499.99, 1),
('Auriculars Bose', 'Auriculars amb so immersiu', 'Auriculars amb so de qualitat superior i cancel·lació de soroll activa.', 'Lleugers i còmodes per a ús prolongat.', '/../images/images.jpg', 299.99, 2),
('Smartwatch Garmin', 'Rellotge intel·ligent', 'Rellotge intel·ligent per a esportistes amb GPS integrat i monitor de ritme cardíac.', 'Resistent a l\aigua fins a 50 metres.', '/../images/images.jpg', 249.99, 2),
('Laptop Acer', 'Portàtil lleuger', 'Un portàtil lleuger amb pantalla de 15.6 polzades.', 'Ideal per a treball i entreteniment.', '/../images/images.jpg', 599.99, 1),
('Smartphone Samsung', 'Smartphone amb càmera', 'Smartphone amb càmera de 64 MP i bateria de llarga durada.', 'Pantalla AMOLED de 6.5 polzades.', '/../images/images.jpg', 399.99, 1),
('Auriculars Sony', 'Auriculars sense fil', 'Auriculars sense fil amb cancel·lació de soroll.', 'Autonomia de fins a 30 hores.', '/../images/images.jpg', 199.99, 2),
('Tablet Apple', 'Tablet amb pantalla Retina', 'Tablet amb pantalla Retina de 10.2 polzades i 128 GB de capacitat.', 'Compatible amb Apple Pencil.', '/../images/images.jpg', 329.99, 2),
('Càmera Canon', 'Càmera digital', 'Càmera rèflex digital amb objectiu de 18-55mm.', 'Ideal per a fotografies de paisatges i retrats.', '/../images/images.jpg', 499.99, 1);

INSERT INTO auctions (auction_date, description, status) 
VALUES (NOW(), 'Subhasta per al producte 1', 'oberta');

INSERT INTO auctions (auction_date, description, status) 
VALUES ('2024-10-10 14:00:00', 'Subhasta finalitzada per al producte 2', 'tancada');

INSERT INTO auctions (auction_date, description, status) 
VALUES (NOW(), 'Subhasta activa per al producte 3','oberta');

INSERT INTO auctions (auction_date, description, status) 
VALUES ('2024-09-25 10:30:00', 'Subhasta tancada per al producte 1', 'tancada');

INSERT INTO notifications (message, sender, receiver) VALUES
('Et donem la benviguda a Subasterra', 3, 1),
('Et donem la benviguda a Subasterra', 3, 2);
