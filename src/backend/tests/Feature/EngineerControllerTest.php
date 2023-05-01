<?php

namespace Tests\Feature;

use App\Models\Engineer;
use Illuminate\Http\Response;
use Tests\TestCase;

class EngineerControllerTest extends TestCase
{
    public function testEngineerIsCreatedSuccessfully()
    {
        $payload = [
            'name' => $this->faker->firstName,
            'surname'  => $this->faker->lastName,
            'phone' => null,
            'email' => $this->faker->email
        ];

        $this->json('post', 'api/engineers', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name',
                        'surname',
                        'phone',
                        'email'
                    ]
                ]
            );
        $this->assertDatabaseHas('engineers', $payload);
    }

    public function testEngineerIsCreatedFail()
    {
        $payload = [
            'name' => $this->faker->firstName,
            'surname'  => $this->faker->lastName,
            'phone' => 12345,         // Некорректный номер
            'email' => $this->faker->email
        ];

        $this->json('post', 'api/engineers', $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(
                [
                    'message',
                    'errors' => [
                        'phone'
                    ]
                ]
            );
    }

    public function testIndexReturnsDataInValidFormat()
    {
        $this->json('get', 'api/engineers')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'surname',
                            'phone',
                            'email'
                        ]
                    ]
                ]
            );
    }

    public function testIndexReturnsDataInValidFormatFilter()
    {
        $this->json('get', 'api/engineers?name=Test')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'surname',
                            'phone',
                            'email'
                        ]
                    ]
                ]
            );
    }

    public function testTaskIsShownCorrectly()
    {

        $engineerData = [
            'name' => $this->faker->firstName,
            'surname'  => $this->faker->lastName,
            'phone' => null,
            'email' => $this->faker->email
        ];

        $engineer = Engineer::create(
            $engineerData
        );

        $this->json('get', "api/engineers/$engineer->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'data' => [
                        'id' => $engineer->id,
                        'name' => $engineer->name,
                        'surname'  => $engineer->surname,
                        'phone' => $engineer->phone,
                        'email' => $engineer->email,
                        'created_at' => $engineer->created_at,
                        'updated_at' => $engineer->updated_at,
                    ]
                ]
            );
    }

    public function testTaskIsDestroyed()
    {
        $engineerData = [
            'name' => $this->faker->firstName,
            'surname'  => $this->faker->lastName,
            'phone' => null,
            'email' => $this->faker->email
        ];

        $engineer = Engineer::create(
            $engineerData
        );

        $this->json('delete', "api/engineers/$engineer->id")
            ->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('engineers', $engineerData);
    }

}
