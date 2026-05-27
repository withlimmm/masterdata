@extends('layouts.main')

@section('title', 'Privacy Policy - ' . ($settings->company_name ?? 'Rakira Digital'))

@section('content')
<div class="pt-32 pb-20 bg-surface-container-lowest min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-on-surface mb-8">Privacy Policy</h1>
        
        <div class="prose prose-slate max-w-none prose-headings:text-on-surface prose-p:text-on-surface-variant">
            <p>Last updated: {{ now()->format('d F Y') }}</p>
            
            <h3>1. Introduction</h3>
            <p>Welcome to {{ $settings->company_name ?? 'Rakira Digital Nusantara' }}. We respect your privacy and are committed to protecting your personal data.</p>
            
            <h3>2. Data We Collect</h3>
            <p>We may collect, use, store and transfer different kinds of personal data about you, including:</p>
            <ul>
                <li>Identity Data (First name, last name, username)</li>
                <li>Contact Data (Email address, telephone numbers)</li>
                <li>Technical Data (IP address, browser type, location)</li>
                <li>Usage Data (Information about how you use our website)</li>
            </ul>

            <h3>3. How We Use Your Data</h3>
            <p>We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>
            <ul>
                <li>To provide and maintain our Service</li>
                <li>To notify you about changes to our Service</li>
                <li>To provide customer support</li>
                <li>To gather analysis or valuable information so that we can improve our Service</li>
            </ul>

            <h3>4. Data Security</h3>
            <p>We have put in place appropriate security measures to prevent your personal data from being accidentally lost, used or accessed in an unauthorized way, altered or disclosed.</p>

            <h3>5. Contact Us</h3>
            <p>If you have any questions about this Privacy Policy, please contact us at:</p>
            <ul>
                <li>Email: {{ $settings->email ?? 'info@rakira.com' }}</li>
                <li>Address: {{ $settings->address ?? 'Indonesia' }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
