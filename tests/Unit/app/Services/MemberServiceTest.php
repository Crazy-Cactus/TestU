<?php

namespace Tests\Unit\app\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberServiceTest extends TestCase
{
    private $memberMocked;

    /*
    * La méthode "setUp" est appelée à chaque excecution de test
    */

    public function setUp()
    {
        parent::setUp();

        $this->memberMocked = \Mockery::mock(Member::class);
    }

    /**
     * Doit ajouter un nouvel email en base de donnée
     * Doit aussi vérifier qu'un email est en cours d'envoi dans le gestionnaire de queue
     *
     * 2 Points
     */

    public function testCreate_NominalCase()
    {
        // Arrange
        $member = 'john.doe@domain.tld';

        // Assert
        $this->memberMocked->shouldReceive('where')
            ->once()
            ->with([
                Member::EMAIL => $member
            ])
            ->andReturn($this->memberMocked);

        $this->memberMocked->shouldReceive('first')
            ->once()
            ->andReturnNull();


        $this->memberMocked->shouldReceive('create')
            ->once()
            ->with([
                Member::EMAIL => $member
            ])
            ->andReturnTrue();

        $memberService = new MemberService($this->memberMocked);

        // Act
        $memberService->create($member);
    }


    /**
     * Doit retourner une exception de type EmailAlreadyExistException
     * si l'email est déjà existant
     *
     * 2 Points
     */

    public function testCreate_ExpectCase()
    {
        // Arrange
        $member = 'john.doe@domain.tld';

        $this->memberMocked->shouldReceive('where')
            ->once()
            ->with([
                Member::EMAIL => $member
            ])
            ->andReturn($this->memberMocked);

        $this->memberMocked->shouldReceive('first')
            ->once()
            ->andReturn(new Member());

        $this->memberMocked->shouldReceive('create')
            ->times(0);

        $memberService = new MemberService($this->memberMocked);

        // Assert
        $this->expectException(EmailAlreadyExistException::class);

        // Act
        $memberService->create($member);
    }
}
