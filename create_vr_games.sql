create table vr_games
(
    id int primary key auto_increment,
    image varchar(200),
    gamename varchar(50) not null,
    subtitle varchar(150),
    description varchar(430),
    price decimal(5, 2) not null
);
insert into vr_games(image, gamename, subtitle, description, price)
values ('./img/chiaro-300x300.png', 'Chiaro', 'THE FIRST-PERSON VR ADVENTURE GAME WHICH WON AN NVIDIA EDGE PROGRAM PRIZE FOR EXCELLENCE IN AESTHETIC ACHIEVEMENT.','Chiaro and the Elixir of Life is a first-person virtual reality adventure game. Step into the role of Chiaro (voiced by Taylor Gray, Star Wars Rebels), a young engineer returning home to the forest of Neverain to build a machine called Boka and bring him to life with Elixir, a powerful ancient fuel. Together Boka and Chiaro form an unbreakable bond and embark on an epic adventure to find the lost Fountain of Elixir','39.99'),
       ('./img/forged-300x300.png', 'Forged', 'FORGED IS A FIRST-PERSON VIRTUAL REALITY ADVENTURE GAME', 'The wonderful story about a strong woman, Qadira, who fights with evil creatures from Dekar. She has devoted her life to fight back the Blossom of Omara, a sinister influence pouring from a rift between worlds that corrupts everything it touches.','59.99');

select * from vr_games;
drop table vr_games;