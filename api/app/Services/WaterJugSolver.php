<?php

namespace App\Services;

class WaterJugSolver
{
    public function solve($xCapacity, $yCapacity, $target)
    {
        // Handle the edge case where the target is 0
        if ($target == 0) {
            return ['solution' => [['bucketX' => 0, 'bucketY' => 0, 'action' => 'No action needed']]];
        }

        // Validate that the inputs are positive integers
        if ($xCapacity <= 0 || $yCapacity <= 0 || $target < 0) {
            return ['error' => 'Invalid input: Jug capacities and target must be positive integers'];
        }

        // Check if the problem is solvable using the greatest common divisor (GCD)
        if ($target > max($xCapacity, $yCapacity) || $target % $this->gcd($xCapacity, $yCapacity) != 0) {
            return ['error' => 'No solution possible'];
        }

        // Compute the steps to solve the problem
        return $this->computeSteps($xCapacity, $yCapacity, $target);
    }

    private function computeSteps($xCapacity, $yCapacity, $target)
    {
        $visited = [];
        $queue = [];

        // Initial state (0, 0) with no steps taken
        $queue[] = [
            'bucketX' => 0,
            'bucketY' => 0,
            'steps' => []
        ];
        $visited['0,0'] = true;

        while (!empty($queue)) {
            $current = array_shift($queue);
            $bucketX = $current['bucketX'];
            $bucketY = $current['bucketY'];
            $steps = $current['steps'];

            // If we've reached the target amount
            if ($bucketX == $target || $bucketY == $target) {
                $steps[] = [
                    'bucketX' => $bucketX,
                    'bucketY' => $bucketY,
                    'action' => 'Solved'
                ];
                return ['solution' => $steps];
            }

            // Generate all possible actions
            $possibleActions = [
                // Fill bucket X
                [
                    'bucketX' => $xCapacity,
                    'bucketY' => $bucketY,
                    'action' => 'Fill bucket X'
                ],
                // Fill bucket Y
                [
                    'bucketX' => $bucketX,
                    'bucketY' => $yCapacity,
                    'action' => 'Fill bucket Y'
                ],
                // Empty bucket X
                [
                    'bucketX' => 0,
                    'bucketY' => $bucketY,
                    'action' => 'Empty bucket X'
                ],
                // Empty bucket Y
                [
                    'bucketX' => $bucketX,
                    'bucketY' => 0,
                    'action' => 'Empty bucket Y'
                ],
                // Transfer from X to Y
                [
                    'bucketX' => max(0, $bucketX - ($yCapacity - $bucketY)),
                    'bucketY' => min($yCapacity, $bucketY + $bucketX),
                    'action' => 'Transfer from X to Y'
                ],
                // Transfer from Y to X
                [
                    'bucketX' => min($xCapacity, $bucketX + $bucketY),
                    'bucketY' => max(0, $bucketY - ($xCapacity - $bucketX)),
                    'action' => 'Transfer from Y to X'
                ]
            ];

            // Explore all possible actions
            foreach ($possibleActions as $nextState) {
                $nextX = $nextState['bucketX'];
                $nextY = $nextState['bucketY'];

                // Check if this state has been visited
                if (!isset($visited["$nextX,$nextY"])) {
                    $visited["$nextX,$nextY"] = true;

                    // Add new state to the queue
                    $queue[] = [
                        'bucketX' => $nextX,
                        'bucketY' => $nextY,
                        'steps' => array_merge($steps, [$nextState])
                    ];
                }
            }
        }

        // No solution found
        return ['error' => 'No solution possible'];
    }

    private function gcd($a, $b)
    {
        return $b == 0 ? $a : $this->gcd($b, $a % $b);
    }
}
