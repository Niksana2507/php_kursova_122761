CREATE DATABASE music;
CREATE USER 'music_user'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON music.* TO 'music_user'@'localhost';
FLUSH PRIVILEGES;