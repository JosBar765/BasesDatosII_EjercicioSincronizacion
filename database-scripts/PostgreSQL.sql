CREATE TABLE "Empleado" (
  "dpi" varchar(13) PRIMARY KEY NOT NULL,
  "primer_nombre" varchar(30),
  "segundo_nombre" varchar(30),
  "primer_apellido" varchar(30),
  "segundo_apellido" varchar(30),
  "direccion" text,
  "telefono_casa" varchar(8) UNIQUE,
  "telefono_movil" varchar(8) UNIQUE,
  "salario_base" decimal(10,2),
  "bonificacion" int,

  "fecha_modificacion" timestamp,
  "eliminado" boolean
);
