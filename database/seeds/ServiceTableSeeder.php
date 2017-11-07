<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use \App\Service;
use \App\Sortie;
use \App\Caisse;
use \App\Comment;
use \App\Horaire;
use \App\Option;
use \App\Entree;
use \App\Events\ServiceStored;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nb_services = 25;
        $now = new Carbon;

        // Recule initialement de 12 Heures pour laisser place pour un nouveau service (TEST phpUnit)
        $now->subHours(12);


        for ($i=0; $i < $nb_services; $i++) { 
            // Recule de 12 Heures par rapport à maintenant
            $now->subHours(12);
            // Choisi un Respo aléatoirement
            $qui = \App\Role::where('name','respo')->first()->users()->get()->random();

            // Crée un service
            $service = factory(Service::class)->create([
                'qui' => $qui->id,
                'quand' => $now->format('Y-m-d').' '.($now->format('a')=='am' ? '08:00:00' : '20:00:00'),
            ]);

            // Crée horaires pour ce service 2-5 au bar, 1-2 en cuisine, 0-2 secu
            factory(Horaire::class,rand(2,5))->create([
                'service_id' => $service->id,
                'role' => \App\Role::where('name','bar')->get()->first()->id
            ]);
            factory(Horaire::class,rand(1,2))->create([
                'service_id' => $service->id,
                'role' => \App\Role::where('name','cuisine')->get()->first()->id
            ]);
            factory(Horaire::class,rand(0,1))->create([
                'service_id' => $service->id,
                'role' => \App\Role::where('name','secu')->get()->first()->id
            ]);

            // Crée une caisse ce service
            $caisse = factory(Caisse::class)->create(['service_id'=>$service->id]);
            
            // Crée des sorties cette caisse (pour ce service)
            $nb_de_sorties = rand(1,4);
            for ($j=0; $j < $nb_de_sorties; $j++) { 
                $type_de_sortie = \App\SortieType::all()->random();
                $data = [
                    'caisse_id' => $caisse->id,
                    'type' => $type_de_sortie->id,
                ];
                if ($type_de_sortie->name=="Avance") {
                    $data['qui'] = \App\User::all()->random()->id;
                    $data['desc'] = "";
                }
                factory(Sortie::class)->create($data);
            }


            // Crée des entrees pour ce service
            $types_d_entree = \App\EntreeType::all();
            foreach ($types_d_entree as $type_d_entree) {
                if( $type_d_entree->expecting == "integer" ){
                    if ( $type_d_entree->facteur <= 10  ) {
                        $max = 15;
                    } elseif ( $type_d_entree->facteur <= 20  ) {
                        $max = 60;
                    } elseif ( $type_d_entree->facteur <= 50  ) {
                        $max = 35;
                    } elseif ( $type_d_entree->facteur > 50 ){
                        $max = 2;
                    }
                    $valeur = rand(0,$max);
                } else {
                    $valeur = rand(0,450)/100;
                }

                factory(Entree::class)->create([
                    'caisse_id' => $caisse->id,
                    'type'      => $type_d_entree->id,
                    'value'     => $valeur,
                ]);
            }

            // Crée des commentaires pour ce service
            factory(Comment::class,2)->create([
                'service'=>$service->id,
            ]);

            event(new ServiceStored($service));

        }


    }
}
