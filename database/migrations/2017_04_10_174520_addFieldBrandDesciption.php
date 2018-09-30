<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFieldBrandDesciption extends Migration
{
    function insert_data($data)
    {
        foreach ($data as $key => $value)
        {
            DB::table('brands')
                ->where('name', '=', $key)
                ->update([
                    'description' => $value
                ]);
        }
    }


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            'Beko' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@arrow) est DCU 7230 W. La référence du modèle est souvent une combinaison de chiffres et de lettres. <br >
                Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le TYPE (@arrow)"
            ]),
            'Brandt' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@arrow) est DCU DFH1310/A. La référence du modèle est souvent une combinaison de chiffres et de lettres.",
                "Dans cette exemple type, Le modèle affiche en (@dot1) est DCU CVP2600. La référence du modèle est souvent une combinaison de chiffres et de lettres.<br >
                Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le TYPE (@dot2)"
            ]),
            'Hotpoint' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@arrow) est SBL 2033 V/HA. La référence du modèle est souvent une combinaison de chiffres et de lettres."
            ]),
            'Indesit' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@arrow) est TAA12 FR. La référence du modèle est souvent une combinaison de chiffres et de lettres.<br >
                Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le CODE (@arrow)",
                "Dans cette exemple type, Le modèle affiche en (@arrow) est IWE 81681 ECO (UK). La référence du modèle est souvent une combinaison de chiffres et de lettres.<br >
                Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le CODE (@arrow)",
                "Dans cette exemple type, Le modèle affiche en (@arrow) est DCU CVP2600. La référence du modèle est souvent une combinaison de chiffres et de lettres.<br >
                Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le TYPE (@arrow) ou le  CODE (@arrow)"
            ]),
            'LG' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@arrow) est VC5402CL. La référence du modèle est souvent une combinaison de chiffres et de lettres."
            ]),
            'Liebherr' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@dot1) est ICBN 3366 index 20C / 001. La référence du modèle est souvent une combinaison de chiffres et de lettres.<br >
                Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le CODE (@dot2) 9987484-03"
            ]),
            'Magimix' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@arrow) est LE MINI PLUS. La référence du modèle est souvent une combinaison de chiffres et de lettres.<br >
                Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le CODE (@arrow) 18216F"
            ]),
            'Miele' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@dot1) est S4222. La référence du modèle est souvent une combinaison de chiffres et de lettres.",
                "Dans cette exemple type, Le modèle affiche en (@arrow) est G 450 SCI. La référence du modèle est souvent une combinaison de chiffres et de lettres."
            ]),
            'Mouline' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@arrow) est MO5335PA/5Q0. La référence du modèle est souvent une combinaison de chiffres et de lettres.",
                "Dans cette exemple type, Le modèle affiche en (@arrow) est FP903A27700. La référence du modèle est souvent une combinaison de chiffres et de lettres."
            ]),
            'Samsung' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@arrow) est LE27T51BX/XEC. La référence du modèle est souvent une combinaison de chiffres et de lettres.",
                "Dans cette exemple type, Le modèle affiche en (@arrow) est M1711NXEO. La référence du modèle est souvent une combinaison de chiffres et de lettres.",
                "Dans cette exemple type, Le modèle affiche en (@arrow) est SC4360. La référence du modèle est souvent une combinaison de chiffres et de lettres.<br >
                Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le CODE (@arrow)"
            ]),
            'Seb' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@arrow) est FF162100/89 A - 2112 R. La référence du modèle est souvent une combinaison de chiffres et de lettres."
            ]),
            'Smeg' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@arrow) est LVD613X. La référence du modèle est souvent une combinaison de chiffres et de lettres."
            ]),
            'Whirlpool' => json_encode([
                "Dans cette exemple type, Le modèle affiche en (@dot1) est ARC140. La référence du modèle est souvent une combinaison de chiffres et de lettres.<br >
                Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le CODE (@dot2)",
                "Dans cette exemple type, Le modèle affiche en (@arrow) est VT275/BL. La référence du modèle est souvent une combinaison de chiffres et de lettres.<br >
                Si vous n'arrivez pas à trouver votre pièce détachée à partir de cette référence, essayez le CODE (@arrow)"
            ])
        ];

       

        Schema::table('brands', function (Blueprint $table) {
            $table->text('description');
        });

        $this->insert_data($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
