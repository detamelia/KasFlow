<?php

namespace Tests\Feature;

use App\Models\KategoriTransaksi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KategoriTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    public function test_kategori_index_page_can_be_rendered(): void
    {
        $response = $this->get(route('kategori.index'));

        $response->assertStatus(200);
        $response->assertSee('Manajemen Kategori');
        $response->assertSee('Total Kategori');
        $response->assertSee('Kategori Pemasukan');
        $response->assertSee('Kategori Pengeluaran');
    }

    public function test_kategori_can_be_filtered_by_jenis(): void
    {
        $response = $this->get(route('kategori.index', ['jenis' => 'pemasukan']));

        $response->assertStatus(200);
        $response->assertSee('Iuran Anggota');
        $response->assertDontSee('Konsumsi');
    }

    public function test_kategori_can_be_searched_by_name(): void
    {
        $response = $this->get(route('kategori.index', ['search' => 'Donasi']));

        $response->assertStatus(200);
        $response->assertSee('Donasi');
        $response->assertDontSee('ATK');
    }

    public function test_new_kategori_can_be_created(): void
    {
        $payload = [
            'nama_kategori' => 'Sponsorship Event',
            'jenis' => 'pemasukan',
            'role' => 'bendahara',
        ];

        $response = $this->post(route('kategori.store'), $payload);

        $response->assertRedirect(route('kategori.index', ['role' => 'bendahara']));
        $this->assertDatabaseHas('kategori_transaksi', [
            'nama_kategori' => 'Sponsorship Event',
            'jenis' => 'pemasukan',
        ]);
    }

    public function test_kategori_creation_validates_required_fields(): void
    {
        $response = $this->post(route('kategori.store'), [
            'nama_kategori' => '',
            'jenis' => 'invalid_jenis',
        ]);

        $response->assertSessionHasErrors(['nama_kategori', 'jenis']);
    }

    public function test_kategori_edit_page_can_be_rendered(): void
    {
        $kategori = KategoriTransaksi::first();

        $response = $this->get(route('kategori.edit', $kategori->id));

        $response->assertStatus(200);
        $response->assertSee($kategori->nama_kategori);
    }

    public function test_kategori_can_be_updated(): void
    {
        $kategori = KategoriTransaksi::create([
            'nama_kategori' => 'Kategori Sementara',
            'jenis' => 'pengeluaran',
        ]);

        $response = $this->put(route('kategori.update', $kategori->id), [
            'nama_kategori' => 'Kategori Diperbarui',
            'jenis' => 'pemasukan',
            'role' => 'bendahara',
        ]);

        $response->assertRedirect(route('kategori.index', ['role' => 'bendahara']));
        $this->assertDatabaseHas('kategori_transaksi', [
            'id' => $kategori->id,
            'nama_kategori' => 'Kategori Diperbarui',
            'jenis' => 'pemasukan',
        ]);
    }

    public function test_kategori_without_transactions_can_be_deleted(): void
    {
        $kategori = KategoriTransaksi::create([
            'nama_kategori' => 'Kategori Unused',
            'jenis' => 'pengeluaran',
        ]);

        $response = $this->delete(route('kategori.destroy', $kategori->id));

        $response->assertRedirect(route('kategori.index', ['role' => 'bendahara']));
        $this->assertDatabaseMissing('kategori_transaksi', [
            'id' => $kategori->id,
        ]);
    }

    public function test_kategori_with_transactions_cannot_be_deleted_to_protect_transaction_data(): void
    {
        // Temukan kategori yang sudah memiliki transaksi dari seeder (misalnya Iuran Anggota)
        $kategori = KategoriTransaksi::has('transaksi')->first();

        $this->assertNotNull($kategori);
        $initialCount = Transaksi::where('kategori_id', $kategori->id)->count();
        $this->assertGreaterThan(0, $initialCount);

        $response = $this->delete(route('kategori.destroy', $kategori->id));

        // Harus gagal menghapus dan menampilkan error
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('kategori_transaksi', [
            'id' => $kategori->id,
        ]);

        // Pastikan transaksi tidak terhapus
        $this->assertEquals($initialCount, Transaksi::where('kategori_id', $kategori->id)->count());
    }
}
