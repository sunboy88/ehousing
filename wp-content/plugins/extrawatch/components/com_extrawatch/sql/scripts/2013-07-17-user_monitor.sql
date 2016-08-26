CREATE TABLE #__extrawatch_user_log (
  id int auto_increment primary key,
  userId int not null,
  countryCodeId int not null,
  loginTimestamp int(11),
  ip varchar(255));