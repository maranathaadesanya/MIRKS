#include <stdio.h>
#include <stdlib.h>
#include <jpeglib.h>

void compress_image(const char* input_filename, const char* output_filename) {
    // Step 1: Open the input file
    FILE* input_file = fopen(input_filename, "rb");
    if (!input_file) {
        printf("Error opening input file.\n");
        return;
    }

    // Step 2: Read the JPEG image data
    struct jpeg_decompress_struct cinfo;
    struct jpeg_error_mgr jerr;

    cinfo.err = jpeg_std_error(&jerr);
    jpeg_create_decompress(&cinfo);
    jpeg_stdio_src(&cinfo, input_file);
    jpeg_read_header(&cinfo, TRUE);
    jpeg_start_decompress(&cinfo);

    // Step 3: Compress and save the image
    FILE* output_file = fopen(output_filename, "wb");
    if (!output_file) {
        printf("Error opening output file.\n");
        jpeg_finish_decompress(&cinfo);
        jpeg_destroy_decompress(&cinfo);
        fclose(input_file);
        return;
    }

    struct jpeg_compress_struct cinfo_out;
    struct jpeg_error_mgr jerr_out;

    cinfo_out.err = jpeg_std_error(&jerr_out);
    jpeg_create_compress(&cinfo_out);
    jpeg_stdio_dest(&cinfo_out, output_file);

    cinfo_out.image_width = cinfo.image_width;
    cinfo_out.image_height = cinfo.image_height;
    cinfo_out.input_components = cinfo.num_components;
    cinfo_out.in_color_space = cinfo.out_color_space;
    jpeg_set_defaults(&cinfo_out);

    // Set the desired compression parameters
    jpeg_set_quality(&cinfo_out, 80, TRUE);  // Adjust the quality level as needed

    // Perform compression
    jpeg_start_compress(&cinfo_out, TRUE);

    JSAMPROW row_pointer[1];
    while (cinfo_out.next_scanline < cinfo_out.image_height) {
        jpeg_read_scanlines(&cinfo, row_pointer, 1);
        jpeg_write_scanlines(&cinfo_out, row_pointer, 1);
    }

    jpeg_finish_compress(&cinfo_out);
    jpeg_destroy_compress(&cinfo_out);
    jpeg_finish_decompress(&cinfo);
    jpeg_destroy_decompress(&cinfo);

    // Step 4: Clean up resources
    fclose(output_file);
    fclose(input_file);
}

int main() {
    const char* input_image = "input.jpg";
    const char* compressed_image = "output.jpg";

    compress_image(input_image, compressed_image);

    printf("Image compression completed.\n");

    return 0;
}
