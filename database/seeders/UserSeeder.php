<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $seller = new Seller();
        $customer = new Customer();

        $count = 4;
        for ($i = 0; $i < $count; $i++) {
            $user = $user->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => Str::random(10),
                'role' => 'seller'
            ]);

            $seller->create([
                'user_id' => $user->id,
                'name' => $user->name,
                'cpf' => $this->generateCnpj(),
            ]);
        }

        $count = 7;

        for ($i = 0; $i < $count; $i++) {

            $customer->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'cpf_cnpj' => $i > 4 ? $this->generateCnpj() : $this->cpf_generate(),
                'person_type' => $i > 4 ? 'legal' : 'physical'
            ]);
        }
    }

    public function generateCnpj()
    {
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n9 = 0;
        $n10 = 0;
        $n11 = 0;
        $n12 = 1;

        $digito1 = ($n12 * 2 + $n11 * 3 + $n10 * 4 + $n9 * 5 + $n8 * 6 + $n7 * 7 + $n6 * 8 + $n5 * 9 + $n4 * 2 + $n3 * 3 + $n2 * 4 + $n1 * 5) % 11;
        $digito1 = $digito1 < 2 ? 0 : 11 - $digito1;

        $digito2 = ($digito1 * 2 + $n12 * 3 + $n11 * 4 + $n10 * 5 + $n9 * 6 + $n8 * 7 + $n7 * 8 + $n6 * 9 + $n5 * 2 + $n4 * 3 + $n3 * 4 + $n2 * 5 + $n1 * 6) % 11;
        $digito2 = $digito2 < 2 ? 0 : 11 - $digito2;

        return sprintf('%02d%03d%03d%04d%02d', $n1, $n2, $n3, $n4 * 1000 + $n5 * 100 + $n6 * 10 + $n7, $n8 * 10 + $n9) . sprintf('%02d', $n10) . sprintf('%02d', $n11) . sprintf('%02d', $n12);
    }

    public function cpf_generate()
    {
        $num = array();
        $num[9] = $num[10] = $num[11] = 0;
        for ($w = 0; $w > -2; $w--) {
            for ($i = $w; $i < 9; $i++) {
                $x = ($i - 10) * -1;
                $w == 0 ? $num[$i] = rand(0, 9) : '';
                echo ($w == 0 ? $num[$i] : '');
                ($w == -1 && $i == $w && $num[11] == 0) ?
                    $num[11] += $num[10] * 2    :
                    $num[10 - $w] += $num[$i - $w] * $x;
            }
            $num[10 - $w] = (($num[10 - $w] % 11) < 2 ? 0 : (11 - ($num[10 - $w] % 11)));
            echo $num[10 - $w];
        }
        return $num[0] . $num[1] . $num[2] . '.' . $num[3] . $num[4] . $num[5] . '.' . $num[6] . $num[7] . $num[8] . '-' . $num[10] . $num[11];
    }
}
