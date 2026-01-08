<?php

if (!function_exists('isImpersonating')) {
    function isImpersonating(): bool
    {
        return session()->has('impersonator_id');
    }
}

if (!function_exists('impersonatorId')) {
    function impersonatorId(): ?int
    {
        return session('impersonator_id');
    }
}