<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FaqTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function faq_can_be_created()
    {
        $faq = Faq::create([
            'question' => 'Test Question Unique XYZ',
            'answer' => 'Test Answer',
            'category' => 'Test',
            'order' => 999,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('faqs', [
            'question' => 'Test Question Unique XYZ',
        ]);
    }

    /** @test */
    public function faq_can_be_updated()
    {
        $faq = Faq::create([
            'question' => 'Original Question Unique',
            'answer' => 'Original Answer',
            'category' => 'Test',
            'order' => 998,
            'is_active' => true,
        ]);

        $faq->update([
            'question' => 'Updated Question Unique',
            'answer' => 'Updated Answer',
        ]);

        $this->assertDatabaseHas('faqs', [
            'id' => $faq->id,
            'question' => 'Updated Question Unique',
            'answer' => 'Updated Answer',
        ]);
    }

    /** @test */
    public function faq_can_be_deleted()
    {
        $faq = Faq::create([
            'question' => 'Question to Delete Unique',
            'answer' => 'Answer',
            'category' => 'Test',
            'order' => 997,
            'is_active' => true,
        ]);

        $faqId = $faq->id;
        $faq->delete();

        $this->assertDatabaseMissing('faqs', [
            'id' => $faqId,
        ]);
    }

    /** @test */
    public function faq_active_scope_filters_correctly()
    {
        // Create active FAQ
        $activeFaq = Faq::create([
            'question' => 'Active FAQ Unique Test',
            'answer' => 'Answer',
            'category' => 'ScopeTest',
            'order' => 996,
            'is_active' => true,
        ]);

        // Create inactive FAQ
        $inactiveFaq = Faq::create([
            'question' => 'Inactive FAQ Unique Test',
            'answer' => 'Answer',
            'category' => 'ScopeTest',
            'order' => 995,
            'is_active' => false,
        ]);

        // Filter by category to only get our test FAQs
        $activeFaqs = Faq::active()->where('category', 'ScopeTest')->get();

        $this->assertCount(1, $activeFaqs);
        $this->assertEquals('Active FAQ Unique Test', $activeFaqs->first()->question);
    }

    /** @test */
    public function faq_ordered_scope_works()
    {
        // Create FAQs with specific order in unique category
        Faq::create([
            'question' => 'Third Ordered FAQ',
            'answer' => 'Answer',
            'category' => 'OrderTest',
            'order' => 3,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'First Ordered FAQ',
            'answer' => 'Answer',
            'category' => 'OrderTest',
            'order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'Second Ordered FAQ',
            'answer' => 'Answer',
            'category' => 'OrderTest',
            'order' => 2,
            'is_active' => true,
        ]);

        // Only get FAQs from our test category
        $faqs = Faq::where('category', 'OrderTest')->ordered()->get();

        $this->assertEquals('First Ordered FAQ', $faqs[0]->question);
        $this->assertEquals('Second Ordered FAQ', $faqs[1]->question);
        $this->assertEquals('Third Ordered FAQ', $faqs[2]->question);
    }

    /** @test */
    public function faq_can_be_grouped_by_category()
    {
        Faq::create([
            'question' => 'Group Test 1',
            'answer' => 'Answer',
            'category' => 'GroupA',
            'order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'Group Test 2',
            'answer' => 'Answer',
            'category' => 'GroupB',
            'order' => 2,
            'is_active' => true,
        ]);

        $grouped = Faq::whereIn('category', ['GroupA', 'GroupB'])
            ->active()
            ->get()
            ->groupBy('category');

        $this->assertArrayHasKey('GroupA', $grouped->toArray());
        $this->assertArrayHasKey('GroupB', $grouped->toArray());
    }

    /** @test */
    public function homepage_loads_with_faqs()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
