<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    public function test_can_list_categories()
    {
        $response = $this->get('/api/category');

        $response->assertStatus(200);
    }

    public function test_can_create_category()
    {
        $categoryData = [
            'name' => $this->faker->word,
            'is_publish' => $this->faker->boolean,
        ];

        $response = $this->post('/api/category', $categoryData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $categoryData);
    }

    public function test_can_show_category()
    {
        $category = Category::factory()->create();

        $response = $this->get('/api/category/' . $category->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $category->name]);
    }

    public function test_can_update_category()
    {
        $category = Category::factory()->create();

        $categoryData = [
            'name' => $this->faker->word,
            'is_publish' => $this->faker->boolean,
        ];

        $response = $this->put('/api/category/' . $category->id, $categoryData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $categoryData);
    }

    public function test_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->delete('/api/category/' . $category->id);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $response->assertStatus(204);
    }
}
