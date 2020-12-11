create table users
(
    username varchar(50) primary key,
    password varchar(255) not null,
    email varchar(50)
);

insert into users(username, password, email)
values ('admin','$2y$12$V1pbm1dUZlfUkkl2mmRIXuQrfYx31J77Gu2N1uKoUiuI0hPIyJ8Da','admin@gmail.com'),

select * from users;

drop table users;