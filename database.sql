create table users(
  id integer primary key autoincrement,
  name text,
  password text,
  point integer
  );

insert into users (name, password, point) values ("user1", "test", 0);
insert into users (name, password, point) values ("user2", "test2", 0);

create table threads(
  id integer primary key autoincrement,
  name text
);

insert into threads (name) values ("テスト");

create table responses(
  id integer primary key autoincrement,
  thread_id integer ,
  content text
);

insert into responses (thread_id, content) values (1, "書いてけ");