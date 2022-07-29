create trigger user_update before update on users
    for each row set new.updated_at = now();

create trigger note_update before update on notes
    for each row set new.updated_at = now();
