create table users
(
    username varchar(50) primary key,
    password varchar(255) not null,
    email varchar(50)
);

insert into users(username, password, email)
values ('kate','$2y$12$xfJyLqqQv56f2Gt3q8z87.bz7UsciDMeqCG..oZwR1nXXxov2v3Zi','kate@gmai.com'),
('anna','$2y$12$wKON53v6u6THSgf9Nz0HKule/TJwkItEGMTVG5lC86Sbad/CFfyEi','anna@gmail.com'),
('alex','$2y$12$BzS/tQ0yiYubRELCjRX3QOwFYfOkEdKRb1.OQFMW55pCqYh.lT/te','alex@gmail.com');

select * from users;

drop table users;