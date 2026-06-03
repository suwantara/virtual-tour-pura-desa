<?php

namespace App\Filament\Clusters\SiteSettings\Pages;

use App\Filament\Clusters\SiteSettings\SiteSettingPage;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageSectionVisibility extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-section-visibility';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEye;

    protected static ?string $navigationLabel = 'Visibilitas Section';

    protected static ?string $title = 'Visibilitas Section';

    protected static ?int $navigationSort = 12;

    public function mount(): void
    {
        $this->form->fill([
            'show_hero' => SiteSetting::get('sections.show_hero', '1') !== '0',
            'show_tentang' => SiteSetting::get('sections.show_tentang', '1') !== '0',
            'show_tour_cta' => SiteSetting::get('sections.show_tour_cta', '1') !== '0',
            'show_pelinggih' => SiteSetting::get('sections.show_pelinggih', '1') !== '0',
            'show_wiki_cta' => SiteSetting::get('sections.show_wiki_cta', '1') !== '0',
            'show_mangku' => SiteSetting::get('sections.show_mangku', '1') !== '0',
            'show_nandika' => SiteSetting::get('sections.show_nandika', '1') !== '0',
            'show_tim' => SiteSetting::get('sections.show_tim', '1') !== '0',
            'show_kontak' => SiteSetting::get('sections.show_kontak', '1') !== '0',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('show_hero')
                    ->label('Hero Section')
                    ->helperText('Bagian paling atas halaman: judul utama, subtitle, dan CTA.'),

                Toggle::make('show_tentang')
                    ->label('Tentang Pura')
                    ->helperText('Sejarah dan statistik Pura Desa.'),

                Toggle::make('show_tour_cta')
                    ->label('Virtual Tour CTA')
                    ->helperText('Ajakan menjelajahi virtual tour 360°.'),

                Toggle::make('show_pelinggih')
                    ->label('Pelinggih')
                    ->helperText('Katalog pelinggih-pelinggih utama.'),

                Toggle::make('show_wiki_cta')
                    ->label('Wiki CTA')
                    ->helperText('Ajakan membaca ensiklopedia digital.'),

                Toggle::make('show_mangku')
                    ->label('Profil Mangku')
                    ->helperText('Profil Jro Mangku Desa.'),

                Toggle::make('show_nandika')
                    ->label('Tentang Nandika')
                    ->helperText('Deskripsi proyek Nandika.'),

                Toggle::make('show_tim')
                    ->label('Tim')
                    ->helperText('Daftar anggota tim dan dosen pembimbing.'),

                Toggle::make('show_kontak')
                    ->label('Kontak')
                    ->helperText('Informasi kontak dan media sosial.'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $keys = [
            'show_hero',
            'show_tentang',
            'show_tour_cta',
            'show_pelinggih',
            'show_wiki_cta',
            'show_mangku',
            'show_nandika',
            'show_tim',
            'show_kontak',
        ];

        foreach ($keys as $key) {
            $value = $state[$key] ?? false;
            SiteSetting::set(
                'sections.'.$key,
                $value ? '1' : '0'
            );
        }

        $this->notifySaved();
    }
}
