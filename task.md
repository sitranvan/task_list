## Bảng users

- user_id primary key => int auto
- username => varchar
- email => varchar
- password => varchar
- forgot_token => varchar
- create_at => datetime
- update_at => datetime

## Bảng login

- login_id primary key => int auto
- user_id => int => foreign key users(user_id)
- token => varchar
- createAt => datetime

## Bảng task

- task_id primary key => int auto
- user_id => int => foreign key users(user_id)
- description => varchar
- status => tinyint
- start_time => datetime
- end_time => datetime
- create_at => datetime
- update_at => datetime
