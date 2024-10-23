<?php

namespace Database\Seeders\GeneralSettings;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $documentTypes = [
            [
                'initials' => 'RC',
                'name' => 'Registro Civil',
                'description' => 'Documento que certifica el nacimiento de una persona y su nacionalidad.',
                'status' => true,
            ],
            [
                'initials' => 'TI',
                'name' => 'Tarjeta de Identidad',
                'description' => 'Documento de identificación para menores de edad colombianos.',
                'status' => true,
            ],
            [
                'initials' => 'CC',
                'name' => 'Cédula de Ciudadanía',
                'description' => 'Documento de identificación para ciudadanos colombianos mayores de edad.',
                'status' => true,
            ],
            [
                'initials' => 'CE',
                'name' => 'Cédula de Extranjería',
                'description' => 'Documento de identificación para extranjeros que residen en Colombia.',
                'status' => true,
            ],
            [
                'initials' => 'PP',
                'name' => 'Pasaporte',
                'description' => 'Documento que permite la identificación de una persona en viajes internacionales.',
                'status' => true,
            ],
            [
                'initials' => 'NI',
                'name' => 'Número de Identificación',
                'description' => 'Número único asignado a cada ciudadano o residente en Colombia.',
                'status' => true,
            ],
            [
                'initials' => 'PEP',
                'name' => 'Permiso Especial de Permanencia',
                'description' => 'Documento que permite a ciudadanos venezolanos residir temporalmente en Colombia.',
                'status' => true,
            ],
            [
                'initials' => 'V',
                'name' => 'Visa',
                'description' => 'Documento que permite la entrada y permanencia en Colombia por un tiempo determinado a extranjeros.',
                'status' => true,
            ],
            [
                'initials' => 'CC-M',
                'name' => 'Cédula de Ciudadanía para menores',
                'description' => 'Cédula expedida a menores de edad que cumplan con ciertos requisitos.',
                'status' => true,
            ],
            [
                'initials' => 'TI-I',
                'name' => 'Tarjeta de Identidad para indígenas',
                'description' => 'Documento de identificación para niños indígenas.',
                'status' => true,
            ],
        ];

        // Insertar los datos en la tabla "document_types"
        DB::table('document_types')->insert($documentTypes);
    }
}
