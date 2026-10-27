{{-- Bots fill every field they find; people never see this one. --}}
<div class="rk-hp" aria-hidden="true">
    <label>Leave this field empty <input type="text" name="{{ \App\Support\SpamGuard::HONEYPOT_FIELD }}" value="" tabindex="-1" autocomplete="off"></label>
</div>
<input type="hidden" name="{{ \App\Support\SpamGuard::TOKEN_FIELD }}" value="{{ old(\App\Support\SpamGuard::TOKEN_FIELD, \App\Support\SpamGuard::token()) }}">
