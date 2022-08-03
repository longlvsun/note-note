alter table notes add constraint fk_owner
    foreign key (owner) references users(id)
        on update cascade
        on delete cascade;
