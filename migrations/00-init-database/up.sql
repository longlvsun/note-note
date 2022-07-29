drop table if exists users;
create table users(
    id serial primary key not null,
    username varchar(255) unique not null,
    hash_passwd varchar(64) not null,
    created_at datetime default current_timestamp,
    updated_at datetime default current_timestamp
);

drop table if exists notes;
create table notes(
    id serial primary key not null,
    owner bigint unsigned not null references users(id),
    created_at datetime default current_timestamp,
    updated_at datetime default current_timestamp,
    content text
);
