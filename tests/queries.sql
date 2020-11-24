create sequence conference_id_seq;
alter table conference alter column id set default nextval('public.conference_id_seq');
alter sequence conference_id_seq owned by conference.id;

create sequence comment_id_seq;
alter table comment alter column id set default nextval('public.comment_id_seq');
alter comment comment_id_seq owned by comment.id;