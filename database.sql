CREATE DATABASE IF NOT EXISTS instagram_master;
USE instagram_master;

CREATE TABLE IF NOT EXISTS users (
    id       int(255) auto_increment not NULL,
    role     VARCHAR(20),
    name     VARCHAR(100),
    surname  VARCHAR(150),
    nick     VARCHAR(100),
    email    VARCHAR(100),
    password VARCHAR(255),
    image    VARCHAR(255),
    created_at   DATETIME,
    updated_at   DATETIME,
    remember_token  VARCHAR(255),
    CONSTRAINT pk_users PRIMARY KEY(id) 
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS images (
    id               int(255) auto_increment not NULL,
    user_id          int(255),
    image_path       VARCHAR(100),
    description      text,
    created_at       DATETIME,
    updated_at       DATETIME,
    CONSTRAINT pk_images PRIMARY KEY(id),
    CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id) 
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS comments (
    id               int(255) auto_increment not NULL,
    user_id          int(255),
    image_id         int(255),
    content          text,
    created_at       DATETIME,
    updated_at       DATETIME,
    CONSTRAINT pk_comments PRIMARY KEY(id),
    CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id) 
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS likes (
    id               int(255) auto_increment not NULL,
    user_id          int(255),
    image_id         int(255),
    created_at       DATETIME,
    updated_at       DATETIME,
    CONSTRAINT pk_likes PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id) 
)ENGINE=InnoDb;