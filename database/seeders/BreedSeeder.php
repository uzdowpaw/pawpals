<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $breeds = [
            'Golden Retriever',
            'Cavalier King Charles Spaniel',
            'Bulldog',
            'Alaskan Malamute',
            'Bernese Mountain Dog',
            'Labrador Retriever',
            'English Springer Spaniel',
            'Shar Pei',
            'Border Collie',
            'Basset Hound',
            'Dachshund',
            'German Wirehaired Pointer',
            'Yorkshire Terrier',
            'German Shepherd',
            'Great Dane',
            'Siberian Husky',
            'Australian Shepherd',
            'French Bulldog',
            'Miniature Schnauzer',
            'Brittany Spaniel',
            'Bouvier des Flandres',
            'Boxer',
            'Great Pyrenees',
            'Havanese',
            'Pembroke Welsh Corgi',
            'English Setter',
            'Beagle',
            'Boston Terrier',
            'German Shorthaired Pointer',
            'Cocker Spaniel',
            'Miniature American Shepherd',
            'Old English Sheepdog',
            'Mastiff',
            'Chow Chow',
            'Vizsla',
            'Doberman Pinscher',
            'Dalmatian',
            'Shih Tzu',
            'Weimaraner',
            'Collie',
            'English Cocker Spaniel',
            'Saint Bernard',
            'Maltese',
            'West Highland White Terrier',
            'Greater Swiss Mountain Dog',
            'Bloodhound',
            'Newfoundland',
            'Akita',
            'Portuguese Water Dog',
            'Chesapeake Bay Retriever',
            'Belgian Malinois',
            'Rhodesian Ridgeback',
            'Papillon',
            'Bullmastiff',
            'Samoyed',
            'Scottish Terrier',
            'Soft-Coated Wheaten Terrier',
            'Shetland Sheepdog',
            'Shiba Inu',
            'Wirehaired Pointing Griffon',
            'Bull Terrier',
            'Welsh Corgi',
            'Pomeranian',
            'Dogue de Bordeaux',
            'Cairn Terrier',
            'Giant Schnauzer',
            'Cane Corso',
            'Irish Wolfhound',
            'Irish Setter',
            'Lhasa Apso',
            'Coton de Tulear',
            'Chihuahua',
            'American Staffordshire Terrier',
            'Neapolitan Mastiff',
            'Standard Schnauzer',
            'Lagotto Romagnolo',
            'Boykin Spaniel',
            'Nova Scotia Duck Tolling Retriever',
            'Airedale Terrier',
            'Bichon Frise',
            'Norwegian Elkhound',
            'Rottweiler',
            'Keeshond',
            'Standard Poodle',
            'Anatolian Shepherd Dog',
            'Brussels Griffon',
            'Jack Russell Terrier',
            'Leonberger',
            'Dogo Argentino',
            'Miniature Pinscher',
            'Whippet',
            'Tibetan Terrier',
            'Pug',
            'Staffordshire Bull Terrier',
            'Australian Cattle Dog',
            'Pekingese',
            'Basenji',
            'Border Terrier',
            'Italian Greyhound',
            'Rat Terrier',
            'Chinese Crested'
        ];

        foreach ($breeds as $breedName) {
            DB::table('breeds')->insertOrIgnore([
                'name' => $breedName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
