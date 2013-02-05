CREATE TABLE TrainStation (
    id SERIAL,
    name VARCHAR(25),
    code VARCHAR(25),
    country VARCHAR(2),
    latitude FLOAT,
    longitude FLOAT,
    alias BOOLEAN DEFAULT false
);
