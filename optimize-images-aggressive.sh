#!/bin/bash

# Aggressive image optimization script for Avora WP
echo "🔥 Starting aggressive image optimization..."

SOURCE_DIR="web/app/themes/avora-wp/images/projects/optimized"
DEST_DIR="web/app/themes/avora-wp/images/projects/web-optimized"

# Ensure destination directory exists
mkdir -p "$DEST_DIR"

# Initialize counters
total_original=0
total_optimized=0
count=0

echo "📁 Processing images from: $SOURCE_DIR"
echo "💾 Saving web-optimized images to: $DEST_DIR"
echo "🎯 Target: Under 500KB per image"
echo ""

# Process each JPG file
for image in "$SOURCE_DIR"/*.jpg; do
    if [ -f "$image" ]; then
        filename=$(basename "$image")
        echo "⚡ Processing: $filename"
        
        # Get original size
        original_size=$(stat -f%z "$image")
        total_original=$((total_original + original_size))
        
        # Method: Resize to max 1200px width and compress to 60% quality
        sips -Z 1200 -s formatOptions 60 "$image" --out "$DEST_DIR/$filename" > /dev/null 2>&1
        
        # Get optimized size
        if [ -f "$DEST_DIR/$filename" ]; then
            optimized_size=$(stat -f%z "$DEST_DIR/$filename")
            
            # If still over 500KB, try 1000px width and 50% quality
            if [ $optimized_size -gt 512000 ]; then
                echo "  🔄 Still too large, applying more compression..."
                sips -Z 1000 -s formatOptions 50 "$image" --out "$DEST_DIR/$filename" > /dev/null 2>&1
                optimized_size=$(stat -f%z "$DEST_DIR/$filename")
                
                # If STILL over 500KB, try 800px width and 40% quality
                if [ $optimized_size -gt 512000 ]; then
                    echo "  🔄 Applying maximum compression..."
                    sips -Z 800 -s formatOptions 40 "$image" --out "$DEST_DIR/$filename" > /dev/null 2>&1
                    optimized_size=$(stat -f%z "$DEST_DIR/$filename")
                fi
            fi
            
            total_optimized=$((total_optimized + optimized_size))
            
            # Calculate reduction
            reduction=$((100 - (optimized_size * 100 / original_size)))
            
            # Convert bytes to KB for display
            original_kb=$((original_size / 1024))
            optimized_kb=$((optimized_size / 1024))
            
            # Color coding based on final size
            if [ $optimized_size -lt 512000 ]; then
                echo "  ✅ Size: ${original_kb}KB → ${optimized_kb}KB (-${reduction}%)"
            else
                echo "  ⚠️  Size: ${original_kb}KB → ${optimized_kb}KB (-${reduction}%) [Still large]"
            fi
            
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
    original_mb=$((total_original / 1024 / 1024))
    optimized_mb=$((total_optimized / 1024 / 1024))
    
    echo "✅ Aggressive optimization complete!"
    echo "📊 Summary:"
    echo "  • Files processed: $count"
    echo "  • Total original size: ${original_mb}MB"
    echo "  • Total optimized size: ${optimized_mb}MB"
    echo "  • Total reduction: ${total_reduction}%"
    echo ""
    echo "🚀 To use web-optimized images:"
    echo "  1. Backup current: mv $SOURCE_DIR ${SOURCE_DIR}.backup"
    echo "  2. Use web-optimized: mv $DEST_DIR $SOURCE_DIR"
    echo ""
    echo "📏 Image specs:"
    echo "  • Max width: 800-1200px (responsive to file size)"
    echo "  • Quality: 40-60% (aggressive compression)"
    echo "  • Target: <500KB per image"
else
    echo "❌ No images found to process"
fi

