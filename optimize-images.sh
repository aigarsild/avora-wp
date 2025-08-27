#!/bin/bash

# Image optimization script for Avora WP
echo "🖼️  Starting image optimization..."

SOURCE_DIR="web/app/themes/avora-wp/images/projects"
DEST_DIR="web/app/themes/avora-wp/images/projects/optimized"

# Ensure destination directory exists
mkdir -p "$DEST_DIR"

# Initialize counters
total_original=0
total_optimized=0
count=0

echo "📁 Processing images from: $SOURCE_DIR"
echo "💾 Saving optimized images to: $DEST_DIR"
echo ""

# Process each JPG file
for image in "$SOURCE_DIR"/*.jpg; do
    if [ -f "$image" ]; then
        filename=$(basename "$image")
        echo "⚡ Processing: $filename"
        
        # Get original size
        original_size=$(stat -f%z "$image")
        total_original=$((total_original + original_size))
        
        # Method 1: Resize to max 1920px width and compress to 80% quality
        sips -Z 1920 -s formatOptions 80 "$image" --out "$DEST_DIR/$filename" > /dev/null 2>&1
        
        # Get optimized size
        if [ -f "$DEST_DIR/$filename" ]; then
            optimized_size=$(stat -f%z "$DEST_DIR/$filename")
            total_optimized=$((total_optimized + optimized_size))
            
            # Calculate reduction
            reduction=$((100 - (optimized_size * 100 / original_size)))
            
            echo "  📉 Size: $(numfmt --to=iec $original_size) → $(numfmt --to=iec $optimized_size) (-${reduction}%)"
            count=$((count + 1))
        else
            echo "  ❌ Failed to optimize $filename"
        fi
        echo ""
    fi
done

# Show summary
if [ $count -gt 0 ]; then
    total_reduction=$((100 - (total_optimized * 100 / total_original)))
    echo "✅ Optimization complete!"
    echo "📊 Summary:"
    echo "  • Files processed: $count"
    echo "  • Total original size: $(numfmt --to=iec $total_original)"
    echo "  • Total optimized size: $(numfmt --to=iec $total_optimized)"
    echo "  • Total reduction: ${total_reduction}%"
    echo ""
    echo "🚀 To use optimized images:"
    echo "  1. Backup originals: mv $SOURCE_DIR $SOURCE_DIR.backup"
    echo "  2. Use optimized: mv $DEST_DIR $SOURCE_DIR"
else
    echo "❌ No images found to process"
fi

