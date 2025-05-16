-- Changed syntax to if not exists so you guys don't get errors if the Database already exists
CREATE DATABASE VinylDatabase;
USE VinylDatabase;

-- Create VinylRecords table for the first time setup
CREATE TABLE VinylRecords (
    id INT PRIMARY KEY AUTO_INCREMENT,
    upc_code VARCHAR(255) NOT NULL,
    band_name VARCHAR(255) NOT NULL,
    album_name VARCHAR(255) NOT NULL,
    album_year INT NOT NULL,
    album_artwork VARCHAR(255) NOT NULL,
    removed BOOLEAN DEFAULT FALSE
);

-- Dummy data for testing purposes (upc codes added for all rows)
-- Images just use random images I pulled from the internet
INSERT INTO VinylRecords (upc_code, band_name, album_name, album_year, album_artwork) VALUES
('1234567890123', 'The Beatles', 'Abbey Road', 1969, 'https://images.gamebanana.com/img/ss/requests/66da72f5bb215.jpg'),
('2345678901234', 'Pink Floyd', 'The Dark Side of the Moon', 1973, 'https://images.gamebanana.com/img/ss/mods/530-90_65e229a2de749.jpg'),
('3456789012345', 'Led Zeppelin', 'IV', 1971, 'https://i.discogs.com/A6caEfeW7k9NBz6mguv5DDOnntwX8TkO3jwgiBaIZZk/rs:fit/g:sm/q:40/h:300/w:300/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9BLTM0Mjc4/LTE2MDQzNzIyNDYt/OTY1NS5qcGVn.jpeg'),
('4567890123456', 'Nirvana', 'Nevermind', 1991, 'https://avatars.githubusercontent.com/u/108231884?v=4'),
('5678901234567', 'Radiohead', 'OK Computer', 1997, 'https://static-cdn.jtvnw.net/jtv_user_pictures/6b99280e-ebef-4154-a14c-2332638188db-profile_image-70x70.png'),
('6789012345678', 'ABBA', 'Ring Ring', 1973, 'https://images.gamebanana.com/img/ss/requests/66da72f5bb215.jpg'),
('7890123456789', 'AC/DC', 'Back in Black', 1980, 'https://images.gamebanana.com/img/ss/mods/530-90_65e229a2de749.jpg'),
('8901234567890', 'Chicago', 'Chicago 16', 1982, 'https://i.discogs.com/A6caEfeW7k9NBz6mguv5DDOnntwX8TkO3jwgiBaIZZk/rs:fit/g:sm/q:40/h:300/w:300/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9BLTM0Mjc4/LTE2MDQzNzIyNDYt/OTY1NS5qcGVn.jpeg'),
('9012345678901', 'Daft Punk', 'Discovery', 2001, 'https://avatars.githubusercontent.com/u/108231884?v=4'),
('0123456789012', 'Earth, Wind & Fire', 'I Am', 1979, 'https://static-cdn.jtvnw.net/jtv_user_pictures/6b99280e-ebef-4154-a14c-2332638188db-profile_image-70x70.png'),
('1123456789012', 'Fugazi', 'Repeater', 1990, 'https://images.gamebanana.com/img/ss/requests/66da72f5bb215.jpg'),
('2123456789012', 'Genesis', 'Nursery Cryme', 1971, 'https://images.gamebanana.com/img/ss/mods/530-90_65e229a2de749.jpg'),
('3123456789012', 'Love', 'Forever Changes', 1967, 'https://i.discogs.com/A6caEfeW7k9NBz6mguv5DDOnntwX8TkO3jwgiBaIZZk/rs:fit/g:sm/q:40/h:300/w:300/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9BLTM0Mjc4/LTE2MDQzNzIyNDYt/OTY1NS5qcGVn.jpeg'),
('4123456789012', 'Nirvana', 'This Means Nothing', 2025, 'https://avatars.githubusercontent.com/u/108231884?v=4'),
('5123456789012', 'Pink Floyd', 'The Endless River', 2014, 'https://static-cdn.jtvnw.net/jtv_user_pictures/6b99280e-ebef-4154-a14c-2332638188db-profile_image-70x70.png');