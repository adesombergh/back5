<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class X extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'X {client=mdp}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transit DB from WP to Laravel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Transition BDD de '. $this->argument('client'));
        $which = "App\Console\Commands\\".ucfirst($this->argument('client'));
        new $which;
        
        define("POSTS_TABLE",DB_PREFIX.'_posts');
        define("POSTMETA_TABLE",DB_PREFIX.'_postmeta');
        define("USERS_TABLE",DB_PREFIX.'_users');
        define("USERMETA_TABLE",DB_PREFIX.'_usermeta');
        define("OPTIONS_TABLE",DB_PREFIX.'_options');


        $this->info('Cleaning current DB');
        Artisan::call('db:seed');

        $this->info('Initializing');



        $get = new Getter;
        $set = new Setter;

        $this->info("Importing Comments / Sorties / Tickets Types");
        // Types Setters
        $set->types_sorties();
        if (isset($GLOBALS['REMARQUES']))
            $set->types_comments();
        if (isset($GLOBALS['TICKETS']))
            $set->types_tickets();

        $this->info("Importing Notes");
        $notes = $get->notes();
        $set->notes($notes);

        // General Setters
        $this->info("Importing Options");
        $set->options_from_db($get);
        $set->options_from_config();

        $this->info("Importing Users");
        $users = $get->users();
        $bar = $this->output->createProgressBar(count($users));
        foreach ($users as $user) {
            $set->users($user);
            $set->role_user($user);
            $bar->advance();
        }
        $bar->finish();


        $this->info(PHP_EOL."Importing Bonus");
        $bar = $this->output->createProgressBar(4*(EKIP_MAXIMUM-EKIP_MINIMUM));
        if (BONUS)
            $set->bonus($get, $bar);
        $bar->finish();

        // Service Related Setters
        $this->info(PHP_EOL."Importing Services");
        $services = $get->services();
        $bar = $this->output->createProgressBar(count($services));
        foreach ($services as $service) {
            $set->services($service);
            $set->afacturer($service);
            $set->sorties($service);
            if (isset($GLOBALS['TICKETS']))
                $set->tickets($service);
            if (isset($GLOBALS['REMARQUES']))
                $set->comments($service);
            $bar->advance();
        }
        $bar->finish();

        $this->info(PHP_EOL."Importing Messages");
        $messages = $get->messages();
        $bar = $this->output->createProgressBar(count($messages));
        foreach ($messages as $message) {
            $set->messages($message);
            $bar->advance();
        }
        $bar->finish();

        $this->info(PHP_EOL."Importing Horaires");
        $horaires = $get->horaires();
        $bar = $this->output->createProgressBar(count($horaires));
        foreach ($horaires as $horaire) {
            if (SALAIRES_EN_VRAC) {
                $set->horaires_en_vrac($horaire);
            } else {
                $set->horaires($horaire);
            }
            $bar->advance();
        }
        $bar->finish();





        if (IMPAYES){
            $this->info(PHP_EOL."Importing Impayés");
            $impayes = $get->impayes();
            $bar = $this->output->createProgressBar(count($impayes));
            foreach ($impayes as $impaye) {
                $set->impayes($impaye);
                $bar->advance();
            }
            $bar->finish();
        } 
        if (MODULE_COFFRE) {
            $this->info(PHP_EOL."Importing Coffre");
            $coffres = $get->coffre();
            $bar = $this->output->createProgressBar(count($coffres));
            foreach ($coffres as $coffre) {
                $set->coffre($coffre);
                $bar->advance();
            }
            $bar->finish();
        }


        $this->info(PHP_EOL.PHP_EOL.'FINISHED! Go have a drink!');

    }
}
