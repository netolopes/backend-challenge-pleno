<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'nome' => $this->faker->jobTitle(),
        'descricao' => $this->faker->realText(100),
        'tipo' => $this->faker->company(),
        'cor' => $this->faker->colorName(),
        'tamanho' => $this->faker->numberBetween($min = 100, $max = 900),
        'valor' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 900),
        'categoria_id' => Categoria::factory(1)->create()->first()
        ];
    }
}
