<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Str;

class DocumentThumbnailGenerator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Product $product, public array $prevDocuments = [])
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $documents = $this->product->documents;

        //delete previous thumbnails if present
        foreach ($this->prevDocuments as $prevDocument) {
            if ($prevDocument['image_path']) {
                info('eed', [$prevDocument['image_path']]);
                Storage::disk($prevDocument['disk'])->delete($prevDocument['image_path']);
            }
        };

        //genearate new thmbnails
        $documents->each(function ($document) {
            try {
                $pdf_tmp_name = Str::uuid() . ".pdf";
                $image_name = Str::uuid() . ".jpg";
                $image_tmp_path =  Storage::disk('temp')->path($image_name);
                $image_path = "products/$document->product_id/$document->section/$image_name";

                //generate temporary pdf file
                $res = Http::get($document->file_url)->body();
                Storage::disk('temp')->put($pdf_tmp_name, $res);

                //generate thumb from first page of the pdf
                $pdf = new Pdf(Storage::disk('temp')->path($pdf_tmp_name));
                $pdf->width(300)->saveImage($image_tmp_path);

                Storage::disk($document->disk)->put($image_path, Storage::disk('temp')->get($image_name));
                $document->update([
                    'image_path' => $image_path,
                ]);


                //delete unncessary temp files
                Storage::disk('temp')->delete($pdf_tmp_name);
                Storage::disk('temp')->delete($image_name);
            } catch (\Throwable $th) {
                //throw $th;
                info('pdf to image conversion failed');
                info($th);
            }
        });
    }
}
