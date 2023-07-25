<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\InvoiceResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceGroup;

use PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::all();
        return InvoiceResource::collection($invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //invoice_number
        $data = json_decode($request->getContent());

        $invoice_date_year = date('Y', strtotime($data->invoice_date));
        $invoice_number = Invoice::where('invoice_group_id', $data->invoice_group_id)
            ->whereYear('invoice_date', $invoice_date_year)
            ->count() + 1;

        $invoice_group = InvoiceGroup::find($data->invoice_group_id);

        $customer = Customer::create([
            'name' => $data->customer->name,
            'address' => $data->customer->address,
        ]);

        $invoice_code = $invoice_group->prefix . str_pad($invoice_number, 6, '0', STR_PAD_LEFT);
        $customer_id = str_pad($customer->id, 6, '0', STR_PAD_LEFT);

        $invoice = Invoice::create([
            'customer_id' => $customer->id,
            'invoice_group_id' => $data->invoice_group_id,
            'invoice_date' => $data->invoice_date,
            'invoice_code' => $invoice_code,
        ]);


        foreach ($data->invoice_items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'code' => $item->code,
                'name' => $item->name,
                'price' => $item->price,
            ]);
        }

        $data = $request->all();
        $data['invoice_code'] = $invoice_code;
        $data['customer_id'] = $customer_id;

        $pdf = PDF::loadView('pdf.viewname', compact('data'));
        $fileName = time() . '_document.pdf';
        $path = 'pdfs/' . $fileName;
        if (!File::isDirectory(public_path('pdfs'))) {
            File::makeDirectory(public_path('pdfs'), 0777, true);
        }
        $pdf->save(public_path($path));
        return response()->json(['message' => 'Invoice successfully created.', 'url' => url($path)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
