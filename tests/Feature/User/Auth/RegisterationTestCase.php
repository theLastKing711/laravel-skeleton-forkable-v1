<?php

namespace Tests\Feature\User\Auth;

use App\Data\User\Auth\Registeration\AddPhoneNumberRegisterationStep\Request\AddPhoneNumberRegisterationStepRequestData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Student\Abstractions\UserTestCase;

class RegisterationTestCase extends UserTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->withRoutePaths('registeration');

    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $this
            ->withRoutePaths(
                'phone-number-step'
            );

        // $logged_in_user = $this
        //     ->getUser();

        // $this->actingAs(
        //     $logged_in_user
        // );

        $registeration_step_request_data =
            new AddPhoneNumberRegisterationStepRequestData(
                phone_number: '0591234567'
            );

        $response =
           $this
               ->postJsonData(
                   $registeration_step_request_data
                       ->toArray()
               );

        $response->assertStatus(200);

    }
}
