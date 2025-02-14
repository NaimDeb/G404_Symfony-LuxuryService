<?php

namespace App\Interfaces;

use App\Entity\Candidate;

interface CandidateCompletionCalculatorInterface
{
    public function calculateCompletion(Candidate $candidate) : int;
}