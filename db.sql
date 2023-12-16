-- в директории заходим в бд и пишем команду:
-- psql \i db.sql 

create table users(
    id serial primary key,
    login varchar(20) not null unique,
    password varchar(50) not null
);

create table favorites(
    id serial primary key,
    url varchar(50) not null unique,
    rating real default 0,
    userId integer not null references users(id)
);

create table blocked(
    id serial primary key,
    url varchar(50) not null unique,
    userId integer not null references users(id)
);