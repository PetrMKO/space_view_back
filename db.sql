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

insert into favorites(url,rating,userId) 
values ('test1','1',1),
('test2','4',1),
('test3','5',1);