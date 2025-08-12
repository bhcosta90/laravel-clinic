<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Schedule;

Schedule::command('telescope:prune')->daily();
Schedule::command(sprintf('queue:prune-batches --hours=%s --unfinished=%s --cancelled=%s', 48, 72, 72))->daily();
