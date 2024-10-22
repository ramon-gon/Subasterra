-- Elimina la base de dades si ja existeix
DROP DATABASE IF EXISTS subasterra;

-- Crea la base de dades si no existeix
CREATE DATABASE IF NOT EXISTS subasterra CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Selecciona la base de dades a utilitzar
USE subasterra;

-- Taula d'usuaris
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador únic per a cada usuari
    username VARCHAR(20) UNIQUE NOT NULL, -- Nom d'usuari únic
    password VARCHAR(20) NOT NULL, -- Contrasenya de l'usuari
    role ENUM('venedor', 'subhastador') NOT NULL -- Rol de l'usuari (venedor o subhastador)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Inserir usuaris de prova
INSERT INTO users (username, password, role) VALUES 
('venedor1', 'venedor1', 'venedor'), -- Venedor de prova
('venedor2', 'venedor2', 'venedor'), -- Un altre venedor de prova
('subhastador', 'subhastador', 'subhastador'); -- Subhastador de prova

-- Taula de productes
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador únic per a cada producte
    name VARCHAR(50) NOT NULL, -- Nom del producte
    short_description TEXT, -- Descripció curta del producte
    long_description TEXT, -- Descripció llarga del producte
    observations TEXT, -- Observacions sobre el producte
    starting_price DECIMAL(10, 2) NOT NULL, -- Preu inicial de la subhasta
    last_bid DECIMAL(10,2) NOT NULL DEFAULT 0,
    photo VARCHAR(50), -- Ruta de la imatge del producte
    status ENUM('pendent', 'rebutjat', 'pendent d’assignació a una subhasta', 'assignat a una subhasta', 'pendent_adjudicacio', 'venut', 'retirat') DEFAULT 'pendent', -- Estat de la validació del producte
    auctioneer_message TEXT, -- Missatge del subhastador en cas d'acceptació o rebuig
    user_id INT, -- Identificador de l'usuari venedor
    FOREIGN KEY (user_id) REFERENCES users(id) -- Clau forana que referencia l'usuari
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS auctions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auction_date TEXT, /* Lo dejo en tipo TEXT temporalmente porque con DATE no recoge la hora */ 
    description TEXT,
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES products(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Inserció de productes de prova
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
