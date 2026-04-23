@extends('vendor.layout.navbar')

@section('title', 'Privacy Policy')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-800 bg-orange-400 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-100 dark:bg-orange-900/30 rounded-xl">
                        <i class="fa fa-shield-halved text-xl text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Privacy Policy</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">How Aerthh handles vendor data and account information</p>
                    </div>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400 bg-white/60 dark:bg-gray-800/60 px-3 py-1.5 rounded-full shadow-sm">
                    Effective: January 2024
                </span>
            </div>
        </div>

        <div class="px-6 py-6 space-y-6 text-sm leading-7 text-gray-700 dark:text-gray-300">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border-l-4 border-blue-500">
                <p class="text-sm">
                    This Privacy Policy applies specifically to <span class="font-semibold text-gray-900 dark:text-white">Aerthh Vendors</span> and explains how we collect, use, share, and protect your information when you use our vendor platform.
                </p>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <i class="fa fa-file-lines text-orange-500 text-base"></i>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">Information We Collect</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-3">
                        <h3 class="font-medium text-gray-900 dark:text-white mb-2"><i class="fa fa-store mr-2 text-orange-500"></i>Business Information</h3>
                        <ul class="list-disc list-inside space-y-1 text-xs text-gray-600 dark:text-gray-400">
                            <li>Store name, legal business name, and GST/VAT number</li>
                            <li>Business registration certificate if applicable</li>
                            <li>Store category and product types</li>
                            <li>Store logo, banner images, and branding materials</li>
                            <li>Business address and warehouse locations</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-3">
                        <h3 class="font-medium text-gray-900 dark:text-white mb-2"><i class="fa fa-user mr-2 text-orange-500"></i>Account Information</h3>
                        <ul class="list-disc list-inside space-y-1 text-xs text-gray-600 dark:text-gray-400">
                            <li>Full name, email address, and phone number</li>
                            <li>Profile photo and government ID for verification</li>
                            <li>Bank account details for payouts</li>
                            <li>PAN or tax identification number</li>
                            <li>Login activity and IP addresses</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-3">
                        <h3 class="font-medium text-gray-900 dark:text-white mb-2"><i class="fa fa-boxes-stacked mr-2 text-orange-500"></i>Product & Inventory Data</h3>
                        <ul class="list-disc list-inside space-y-1 text-xs text-gray-600 dark:text-gray-400">
                            <li>Product names, descriptions, and pricing</li>
                            <li>Product images and videos</li>
                            <li>Stock levels and inventory history</li>
                            <li>SKU codes and category assignments</li>
                            <li>Shipping weights and dimensions</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-3">
                        <h3 class="font-medium text-gray-900 dark:text-white mb-2"><i class="fa fa-indian-rupee-sign mr-2 text-orange-500"></i>Order & Financial Data</h3>
                        <ul class="list-disc list-inside space-y-1 text-xs text-gray-600 dark:text-gray-400">
                            <li>Order details and customer information</li>
                            <li>Sales reports and revenue analytics</li>
                            <li>Commission fees and payout records</li>
                            <li>Refund and return history</li>
                            <li>Tax invoice documents</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <i class="fa fa-gear text-orange-500 text-base"></i>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">How We Use Your Data</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="flex items-start gap-2">
                        <i class="fa fa-circle-check text-green-500 mt-1"></i>
                        <span>Process customer orders and manage deliveries</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class="fa fa-circle-check text-green-500 mt-1"></i>
                        <span>Calculate and process vendor payouts</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class="fa fa-circle-check text-green-500 mt-1"></i>
                        <span>Verify vendor identity and prevent fraud</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class="fa fa-circle-check text-green-500 mt-1"></i>
                        <span>Generate sales analytics and performance reports</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class="fa fa-circle-check text-green-500 mt-1"></i>
                        <span>Communicate important platform updates</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class="fa fa-circle-check text-green-500 mt-1"></i>
                        <span>Resolve disputes and handle returns</span>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <i class="fa fa-share-nodes text-orange-500 text-base"></i>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">Information Sharing</h2>
                </div>
                <p>We share your vendor information only in these circumstances:</p>
                <ul class="list-disc list-inside space-y-1 ml-2">
                    <li><span class="font-medium">With Customers:</span> Store name, product listings, and business contact details</li>
                    <li><span class="font-medium">With Payment Partners:</span> Bank details for payout processing</li>
                    <li><span class="font-medium">With Logistics Partners:</span> Warehouse address for order pickup</li>
                    <li><span class="font-medium">Legal Compliance:</span> When required by law or tax authorities</li>
                </ul>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <i class="fa fa-shield-halved text-orange-500 text-base"></i>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">Data Protection & Security</h2>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                    <p class="mb-2">We implement industry-standard security measures including:</p>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        <li><i class="fa fa-lock text-green-600 mr-1"></i>256-bit SSL encryption for all data transmission</li>
                        <li><i class="fa fa-lock text-green-600 mr-1"></i>Two-factor authentication for vendor accounts</li>
                        <li><i class="fa fa-lock text-green-600 mr-1"></i>Regular security audits and penetration testing</li>
                        <li><i class="fa fa-lock text-green-600 mr-1"></i>Secure AWS servers with access controls</li>
                        <li><i class="fa fa-lock text-green-600 mr-1"></i>Automated backup systems for data recovery</li>
                        <li><i class="fa fa-lock text-green-600 mr-1"></i>Role-based access to sensitive information</li>
                    </ul>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <i class="fa fa-user-shield text-orange-500 text-base"></i>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">Your Rights as a Vendor</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <div class="text-xl mb-1"><i class="fa fa-download text-orange-500"></i></div>
                        <div class="font-medium text-gray-900 dark:text-white text-xs">Access Data</div>
                        <div class="text-xs text-gray-500">Request your data export</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <div class="text-xl mb-1"><i class="fa fa-pen-to-square text-orange-500"></i></div>
                        <div class="font-medium text-gray-900 dark:text-white text-xs">Correct Data</div>
                        <div class="text-xs text-gray-500">Update inaccurate information</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <div class="text-xl mb-1"><i class="fa fa-trash-can text-orange-500"></i></div>
                        <div class="font-medium text-gray-900 dark:text-white text-xs">Delete Account</div>
                        <div class="text-xs text-gray-500">Request account deletion</div>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <i class="fa fa-clock text-orange-500 text-base"></i>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">Data Retention Period</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="text-left p-2">Data Type</th>
                                <th class="text-left p-2">Retention Period</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr><td class="p-2">Active account data</td><td class="p-2">Until account closure + 30 days</td></tr>
                            <tr><td class="p-2">Order & transaction history</td><td class="p-2">7 years (tax/legal requirement)</td></tr>
                            <tr><td class="p-2">Bank & payout details</td><td class="p-2">Until account closure + 90 days</td></tr>
                            <tr><td class="p-2">Product listings</td><td class="p-2">30 days after product deletion</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <i class="fa fa-envelope text-orange-500 text-base"></i>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">Contact Us</h2>
                </div>
                <div class="bg-orange-50 dark:bg-orange-900/20 rounded-lg p-4">
                    <p class="mb-2">For privacy-related questions or to exercise your rights:</p>
                    <div class="space-y-1 text-sm">
                        <p><i class="fa fa-at text-orange-500 mr-1"></i><span class="font-medium">Email:</span> <a href="mailto:privacy@aerthh.com" class="text-orange-600 hover:underline">privacy@aerthh.com</a></p>
                        <p><i class="fa fa-comments text-orange-500 mr-1"></i><span class="font-medium">Vendor Support:</span> Access via your vendor dashboard</p>
                        <p><i class="fa fa-phone text-orange-500 mr-1"></i><span class="font-medium">Phone:</span> +1 (800) 123-4567 (Mon-Fri, 9AM-6PM)</p>
                        <p class="text-xs text-gray-500 mt-2">Response time: 2-3 business days</p>
                    </div>
                </div>
            </div>

            <div class="text-xs text-center text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-800 pt-4 mt-4">
                <p>We may update this Privacy Policy periodically. Changes will be notified via email and your vendor dashboard.</p>
                <p class="mt-1">© {{ date('Y') }} Aerthh. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>
@endsection
