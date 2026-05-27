@extends('layouts.main')

@section('title', 'Terms of Service - ' . ($settings->company_name ?? 'Rakira Digital'))

@section('content')
<div class="pt-32 pb-20 bg-surface-container-lowest min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-on-surface mb-8">Terms of Service</h1>
        
        <div class="prose prose-slate max-w-none prose-headings:text-on-surface prose-p:text-on-surface-variant">
            <p>Last updated: {{ now()->format('d F Y') }}</p>
            
            <h3>1. Agreement to Terms</h3>
            <p>By accessing or using our website, you agree to be bound by these Terms of Service. If you disagree with any part of the terms, then you may not access the Service.</p>
            
            <h3>2. Intellectual Property</h3>
            <p>The Service and its original content, features and functionality are and will remain the exclusive property of {{ $settings->company_name ?? 'Rakira Digital Nusantara' }} and its licensors. The Service is protected by copyright, trademark, and other laws.</p>

            <h3>3. Use License</h3>
            <p>Permission is granted to temporarily download one copy of the materials (information or software) on our website for personal, non-commercial transitory viewing only.</p>
            
            <h3>4. Limitation of Liability</h3>
            <p>In no event shall {{ $settings->company_name ?? 'Rakira Digital Nusantara' }}, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your access to or use of or inability to access or use the Service.</p>

            <h3>5. Changes</h3>
            <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms.</p>

            <h3>6. Contact Us</h3>
            <p>If you have any questions about these Terms, please contact us at:</p>
            <ul>
                <li>Email: {{ $settings->email ?? 'info@rakira.com' }}</li>
                <li>Phone: {{ $settings->phone ?? '+62 878-6818-4742' }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
