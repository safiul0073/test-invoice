<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use PDF;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Invoice/Index', [
            'invoices' => Invoice::withSum('invoiceItems as total_quantity', 'quantity')->withSum('invoiceItems as total_amount', 'unit_price')->with(['user:id,name'])->paginate(),
        ]);
    }

    public function create()
    {
        return Inertia::render(
            'Invoice/Create',
            [
                'users' => \App\Models\User::where('type', 'customer')->select('id', 'name')->get(),
                'products' => \App\Models\Product::paginate(),
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $attribute = $request->validated();
        $user = User::find((int) $attribute['user_id']);

        // try {
        //     DB::beginTransaction();
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'date' => now(),
            ]);

            $items = [];
            $total_amount = 0;

            $invoice->invoiceItems()->createMany(array_map(function ($item) use($items, $total_amount) {
                $product = Product::find((int) $item['product_id']);
                $items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price * $item['quantity'],
                ];
                $total_amount += $product->price * $item['quantity'];
                return [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price * $item['quantity'],
                ];
            }, $attribute['items']));

             $data = [
                'invoice_id' => $invoice->id,
                'customer_name' => $user->name,
                'date' => $invoice->date,
                'customer_email' => $user->email,
                'total_amount' => $total_amount,
                'items' => $items
            ];

            // Generating PDF
            $pdf = PDF::loadView('invoice', ['data' => $data]);
            $pdfPath = public_path('invoices/invoice.pdf');
            $pdf->save($pdfPath);

            /** sending mail with attachment */
            Mail::to('safiul7303@gmail.com')->send(new InvoiceMail($pdfPath));
        //     DB::commit();
        // } catch (\Exception $ex) {
        //     DB::rollBack();
        //     return redirect()->route('invoice.create')->with('message', 'Invoice not Created!');
        // }

        return redirect()->route('invoice.index')->with('message', 'Invoice Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return Inertia::render(
            'Invoice/Show'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        return Inertia::render(
            'Invoice/Edit', [
                'invoice' => $invoice
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return redirect()->route('invoice.index')->with('message', 'Invoice Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoice.index')->with('message', 'Invoice Delete Successfully');
    }
}
