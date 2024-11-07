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
    status ENUM('oberta', 'tancada', 'iniciada') NOT NULL DEFAULT 'oberta',
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
('Televisor LG', 'Televisor 4K UHD', 'Televisor LG de 55 polzades amb resolució 4K i compatibilitat amb HDR.', 'Pantalla amb alta resolució i colors vius.', '/../images/lgtv.jpg', 699.99, 2),
('Consola PlayStation 5', 'Consola de nova generació', 'Consola de jocs PlayStation 5 amb gràfics de nova generació i SSD ultra ràpid.', 'Inclou un controlador extra i un joc.', '/../images/ps5.jpg', 499.99, 1),
('Auriculars Bose', 'Auriculars amb so immersiu', 'Auriculars amb so de qualitat superior i cancel·lació de soroll activa.', 'Lleugers i còmodes per a ús prolongat.', '/../images/bosehp.jpg', 299.99, 2),
('Smartwatch Garmin', 'Rellotge intel·ligent', 'Rellotge intel·ligent per a esportistes amb GPS integrat i monitor de ritme cardíac.', 'Resistent a l\aigua fins a 50 metres.', '/../images/smartwatch.jpg', 249.99, 2),
('Laptop Acer', 'Portàtil lleuger', 'Un portàtil lleuger amb pantalla de 15.6 polzades.', 'Ideal per a treball i entreteniment.', '/../images/acer.jpg', 599.99, 1),
('Smartphone Samsung', 'Smartphone amb càmera', 'Smartphone amb càmera de 64 MP i bateria de llarga durada.', 'Pantalla AMOLED de 6.5 polzades.', '/../images/samsung.jpg', 399.99, 1),
('Auriculars Sony', 'Auriculars sense fil', 'Auriculars sense fil amb cancel·lació de soroll.', 'Autonomia de fins a 30 hores.', '/../images/sonyhp.jpg', 199.99, 2),
('Tablet Apple', 'Tablet amb pantalla Retina', 'Tablet amb pantalla Retina de 10.2 polzades i 128 GB de capacitat.', 'Compatible amb Apple Pencil.', '/../images/ipad.jpg', 329.99, 2),
('Càmera Canon', 'Càmera digital', 'Càmera rèflex digital amb objectiu de 18-55mm.', 'Ideal per a fotografies de paisatges i retrats.', '/../images/canon.jpg', 499.99, 1),
('Bicicleta de Muntanya', 'Bicicleta resistent', 'Bicicleta de muntanya amb 21 velocitats i suspensió doble.', 'Ideal per a camins i rutes de muntanya.', '/../images/bicicleta.jpg', 299.99, 2),
('Aspirador Dyson', 'Aspirador sense fil', 'Aspirador sense fil amb alta potència i tecnologia ciclònica.', 'Inclou accessoris per a superfícies difícils.', '/../images/dyson.jpg', 399.99, 1),
('Altaveu Bluetooth JBL', 'Altaveu portàtil', 'Altaveu portàtil amb connectivitat Bluetooth i resistent', 'Durada de bateria de fins a 12 hores.', '/../images/jbl.jpg', 89.99, 2),
('Cafetera Nespresso', 'Cafetera de càpsules', 'Cafetera Nespresso amb sistema de càpsules i escuma de llet automàtica.', 'Ve amb pack de benvinguda de càpsules.', '/../images/nespresso.jpg', 129.99, 2),
('Rellotge Casio', 'Rellotge clàssic', 'Rellotge Casio amb pantalla digital i cronòmetre.', 'Clàssic i resistent', '/../images/casio.jpg', 39.99, 1),
('Escúter Elèctric', 'Escúter amb autonomia llarga', 'Escúter elèctric amb autonomia de 25 km i velocitat màxima de 20 km/h.', 'Plegable i fàcil de transportar.', '/../images/scuter.jpg', 499.99, 2),
('Llum LED', 'Llum per a fotografia', 'Llum LED amb temperatura de color ajustable per a selfies i vídeo.', 'Inclou trípode ajustable.', '/../images/ringlight.jpg', 59.99, 2),
('Robot Aspirador Xiaomi', 'Aspirador intel·ligent', 'Robot aspirador amb sistema de navegació làser', 'Compatible amb Alexa i Google Home.', '/../images/robot.jpg', 249.99, 1),
('Microones Samsung', 'Microones amb grill', 'Microones Samsung amb funció grill i interior ceràmic.', 'Fàcil de netejar i de gran capacitat.', '/../images/microones.jpg', 139.99, 1),
('Cascos Gaming Razer', 'Auriculars gaming amb micròfon', 'Auriculars Razer amb micròfon retràctil i so envoltant 7.1.', 'Ideals per a sessions llargues de joc.', '/../images/razercascos.jpg', 149.99, 1),
('Monitor Dell', 'Monitor Full HD', 'Monitor Dell de 27 polzades amb resolució Full HD i tecnologia IPS.', 'Angles de visió amplis i colors precisos.', '/../images/dellmonitor.jpg', 229.99, 2),
('Escàner HP', 'Escàner d’alta resolució', 'Escàner d’alta resolució HP per a documents i fotografies.', 'Escaneig ràpid i amb detall.', '/../images/hpscanner.jpg', 89.99, 1),
('Càmera GoPro', 'Càmera d’acció', 'Càmera d’acció GoPro amb resistència a l’aigua fins a 10 m.', 'Ideal per a esports extrems i aventures.', '/../images/gopro.jpg', 329.99, 2),
('Projector Epson', 'Projector amb alta resolució', 'Projector Epson amb resolució 1080p i connexió HDMI.', 'Ideal per a presentacions i pel·lícules.', '/../images/epsonprojector.jpg', 499.99, 1),
('Batedora Moulinex', 'Batedora de mà', 'Batedora de mà amb accessoris per a picar i batre.', 'Potent i fàcil de netejar.', '/../images/moulinex.jpg', 59.99, 1),
('Càmera Instax Fujifilm', 'Càmera instantània', 'Càmera instantània Fujifilm Instax amb mode de selfies.', 'Disponible en diferents colors.', '/../images/instax.jpg', 69.99, 2),
('Casc de Realitat Virtual Oculus', 'Casc de realitat virtual', 'Casc de realitat virtual Oculus amb controladors sense fil.', 'Experiència immersiva per a jocs.', '/../images/oculus.jpg', 399.99, 2);

INSERT INTO auctions (auction_date, description, status) 
VALUES ('2024-11-15 10:00:00', 'Productes electrodomèstics', 'oberta');

INSERT INTO auctions (auction_date, description, status) 
VALUES ('2024-11-15 11:00:00', 'Productes audiovisuals', 'oberta');

INSERT INTO auctions (auction_date, description, status) 
VALUES ('2024-11-15 12:00:00', 'Productes electrònics','oberta');

INSERT INTO auctions (auction_date, description, status) 
VALUES ('2024-09-25 10:30:00', 'Subhasta tancada', 'tancada');

INSERT INTO notifications (message, sender, receiver) VALUES
('Et donem la benviguda a Subasterra', 3, 1),
('Et donem la benviguda a Subasterra', 3, 2);
