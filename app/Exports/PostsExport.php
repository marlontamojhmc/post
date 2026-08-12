<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PostsExport implements
    FromCollection,
    WithCustomStartCell,
    WithDrawings,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnWidths
{
    /*
    |--------------------------------------------------------------------------
    | Get Posts
    |--------------------------------------------------------------------------
    */

    public function collection()
    {
        return Post::with('verifier')->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Table Starting Position
    |--------------------------------------------------------------------------
    */

    public function startCell(): string
    {
        return 'A6';
    }

    /*
    |--------------------------------------------------------------------------
    | Table Headings
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Description',
            'Verified At',
            'Verified By',
            'Created At',
            'Updated At',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Organization Logo
    |--------------------------------------------------------------------------
    */

    public function drawings()
    {
        $drawing = new Drawing();

        $drawing->setName('JHMC Logo');

        $drawing->setDescription(
            'John Hay Management Corporation Logo'
        );

        $drawing->setPath(
            public_path('images/jhmc-logo.png')
        );

        /*
        |--------------------------------------------------------------------------
        | Logo Size
        |--------------------------------------------------------------------------
        */

        $drawing->setHeight(65);

        /*
        |--------------------------------------------------------------------------
        | Logo Position
        |--------------------------------------------------------------------------
        |
        | Top-left
        |
        */

        $drawing->setCoordinates('A1');

        $drawing->setOffsetX(10);
        $drawing->setOffsetY(5);

        return $drawing;
    }

    /*
    |--------------------------------------------------------------------------
    | Map Database Records
    |--------------------------------------------------------------------------
    */

    public function map($post): array
    {
        return [
            $post->id,

            $post->title,

            $post->description,

            $post->verified_at
                ? $post->verified_at->format('Y-m-d H:i:s')
                : null,

            $post->verifier?->name ?? 'Not Verified',

            $post->created_at
                ? $post->created_at->format('Y-m-d H:i:s')
                : null,

            $post->updated_at
                ? $post->updated_at->format('Y-m-d H:i:s')
                : null,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Worksheet Styles
    |--------------------------------------------------------------------------
    */

    public function styles(Worksheet $sheet)
    {
        /*
        |--------------------------------------------------------------------------
        | ORGANIZATION NAME
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells('C1:G1');

        $sheet->setCellValue(
            'C1',
            'John Hay Management Corporation'
        );

        $sheet->getStyle('C1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
            ],

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | REPORT TITLE
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells('C2:G2');

        $sheet->setCellValue(
            'C2',
            'Posts Report'
        );

        $sheet->getStyle('C2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | GENERATED DATE
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells('C3:G3');

        $sheet->setCellValue(
            'C3',
            'Generated: ' . now()->format('F d, Y h:i A')
        );

        $sheet->getStyle('C3')->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 10,
            ],

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | HEADER ROW HEIGHTS
        |--------------------------------------------------------------------------
        */

        $sheet->getRowDimension(1)->setRowHeight(75);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->getRowDimension(3)->setRowHeight(20);

        /*
        |--------------------------------------------------------------------------
        | TABLE HEADER
        |--------------------------------------------------------------------------
        */

        $sheet->getRowDimension(6)->setRowHeight(25);

        $sheet->getStyle('A6:G6')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
            ],

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],

            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | TABLE BORDERS
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A6:G1000')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | DESCRIPTION WRAPPING
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('C7:C1000')
            ->getAlignment()
            ->setWrapText(true);

        /*
        |--------------------------------------------------------------------------
        | DATA ALIGNMENT
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A7:G1000')
            ->getAlignment()
            ->setVertical('top');

        /*
        |--------------------------------------------------------------------------
        | FREEZE HEADER
        |--------------------------------------------------------------------------
        */

        $sheet->freezePane('A7');

        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $sheet->setAutoFilter('A6:G6');

        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Column Widths
    |--------------------------------------------------------------------------
    */

    public function columnWidths(): array
    {
        return [
        'A' => 12,  // ID
        'B' => 45,  // Title
        'C' => 80,  // Description
        'D' => 22,  // Verified At
        'E' => 25,  // Verified By
        'F' => 22,  // Created At
        'G' => 22,  // Updated At
    ];
    }
}