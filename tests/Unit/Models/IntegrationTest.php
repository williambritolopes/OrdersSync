<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\Integration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_integration_belongs_to_a_company(): void
    {
        $company = Company::factory()->create();

        $integration = Integration::factory()
            ->for($company)
            ->create();

        $this->assertTrue($integration->company->is($company));
    }

    public function test_integration_credentials_are_encrypted_and_decrypted(): void
    {
        $credentials = [
            'access_token' => 'secret-token-123',
            'client_secret' => 'secret-value-456',
        ];

        $integration = Integration::factory()->create([
            'credentials' => $credentials,
        ]);

        $this->assertSame($credentials, $integration->credentials);

        $storedCredentials = $integration->getRawOriginal('credentials');

        $this->assertIsString($storedCredentials);
        $this->assertStringNotContainsString(
            'secret-token-123',
            $storedCredentials
        );
        $this->assertStringNotContainsString(
            'secret-value-456',
            $storedCredentials
        );
    }

    public function test_integration_active_status_is_cast_to_boolean(): void
    {
        $integration = Integration::factory()->create([
            'is_active' => 1,
        ]);

        $this->assertIsBool($integration->is_active);
        $this->assertTrue($integration->is_active);
    }
}
