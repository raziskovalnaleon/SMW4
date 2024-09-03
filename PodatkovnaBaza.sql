CREATE TABLE "ucenci"(
    "emso" BIGINT NOT NULL,
    "ime" NVARCHAR(255) NOT NULL,
    "priimek" NVARCHAR(255) NOT NULL,
    "datum_r" DATE NOT NULL,
    "kraj_r" NVARCHAR(255) NOT NULL,
    "razred" CHAR(255) NOT NULL,
    "geslo" NVARCHAR(255) NOT NULL
);
ALTER TABLE
    "ucenci" ADD CONSTRAINT "ucenci_emso_primary" PRIMARY KEY("emso");
CREATE TABLE "razred"(
    "id" BIGINT NOT NULL,
    "ime_razred" BIGINT NOT NULL,
    "st_ucenca" BIGINT NOT NULL,
    "id_ucenca" BIGINT NOT NULL,
    "id_ucitelj" BIGINT NOT NULL
);
ALTER TABLE
    "razred" ADD CONSTRAINT "razred_id_primary" PRIMARY KEY("id");
CREATE TABLE "ucitelji"(
    "emso" BIGINT NOT NULL,
    "ime" NVARCHAR(255) NOT NULL,
    "priimek" NVARCHAR(255) NOT NULL,
    "datum_r" DATE NOT NULL,
    "predmet_u" NVARCHAR(255) NOT NULL,
    "geslo" NVARCHAR(255) NOT NULL
);
ALTER TABLE
    "ucitelji" ADD CONSTRAINT "ucitelji_emso_primary" PRIMARY KEY("emso");
CREATE TABLE "admin"(
    "id" BIGINT NOT NULL,
    "ime" NVARCHAR(255) NOT NULL,
    "priimek" NVARCHAR(255) NOT NULL,
    "geslo" NVARCHAR(255) NOT NULL
);
ALTER TABLE
    "admin" ADD CONSTRAINT "admin_id_primary" PRIMARY KEY("id");
ALTER TABLE
    "razred" ADD CONSTRAINT "razred_id_ucenca_foreign" FOREIGN KEY("id_ucenca") REFERENCES "ucenci"("emso");
ALTER TABLE
    "razred" ADD CONSTRAINT "razred_id_ucitelj_foreign" FOREIGN KEY("id_ucitelj") REFERENCES "ucitelji"("emso");