<?php

namespace App\Jobs;

use PDF;
use QrCode;
use App\Models\User;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
Use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProductPDFGenerator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    Public $user;
    public $timeout = 600;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->connection = 'export-pdf';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $lang = $this->user->language->code;
        $products = Product::query()
                    ->select('id','prefix_id', 'name', 'serial_number','status', 'supplier_id' ,'category_id')
                    ->where('company_id', $this->user->company_id)
                    ->with('supplier:id,name','category:id,name')
                    ->limit(10)
                    ->get();

        $folder_name = 'QrCode/'.uniqid().'/';
        foreach($products as $product){

            $string = ['id' => $product->id, 'type' => 'product'];
            $image = QrCode::format('png')
                    ->size(300)
                    ->generate(json_encode($string));

            Storage::disk(getDisk())->put($folder_name."{$product->id}.png", $image);

        }

        $pdf_name = uniqid().'.pdf';

        $pdf = PDF::loadView('pdf', compact('products','lang', 'folder_name'))->setPaper('a4', 'portrait');

        Storage::disk(getDisk())->put($folder_name.$pdf_name, $pdf->output());

        $file_name = $folder_name.$pdf_name;

        if (getDisk() == 'public') {
            $file_url = Storage::disk('public')->url($file_name);
        } else if (getDisk() =='exoscale') {
            $file_url = Storage::disk('exoscale')->publicUrl($file_name);
        }

        Mail::send(['html' =>'mail.product_pdf'], [
             'file_name'=> $file_name,
             'name' => $this->user->first_name . ' ' . $this->user->last_name,
             'lang' => $this->user->language->code
        ],
        function ($message) use ($file_url)
        {
            $message->to($this->user->email, '')
                ->subject( trans('OnDoc - PDF Export', [], $this->user->language->code) )
                ->attach($file_url, [
                    'as' => 'Product-List.pdf',
                    'mime' => 'application/pdf'
                ]);
        });

    }
}
